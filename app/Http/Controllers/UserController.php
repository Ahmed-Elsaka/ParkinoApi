<?php

namespace App\Http\Controllers;
use App\BindCard;
use App\Http\Resources\CardResource;
use App\Http\Resources\ChangeInfoResource;
use App\Http\Resources\changePassword;
use App\Http\Resources\GetGarageClientsResource;
use App\Http\Resources\GetGaragesResource;
use App\Http\Resources\LoginResource;
use App\Http\Resources\MyCardsResource;
use App\Http\Resources\testResource;
use App\Http\Resources\UserProfileResource;
use App\Login;
use App\MakeReservation;
use App\MessageModel;
use App\ParkingArea;
use App\SystemCards;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use phpDocumentor\Reflection\Types\Null_;

class UserController extends Controller
{
    // test api work function
    public function work()
    {
        return "its working";
    }
    // Phone API
    // Resource function
    public function registerLoginREs( $status,$requestType,$message,Request $request){
        // return model to resouce depend on login or register
        $login = new Login();
        $user = new User();
        if($status ==1){
            $login->status = 1;
            $login->message = $message;
            $login->id = DB::table('users')->where('email',$request->email)->value('id');
            if($requestType =='registerRequest'){
                return new LoginResource($login);
            }else{
                $login->user_name = DB::table('users')->where('email',$request->email)->value('name');
                $login->phone_number = DB::table('users')->where('email',$request->email)->value('phone_number');
                // $login->user_name = 'ahmed';
                $login->email = $request->email;
                return new LoginResource($login);
            }

        }else{
            $login->status = 0;
            $login->message = $message;
            return new LoginResource($login);
        }

    }
    public function register(Request $request, User $user){
       // $count = $user->find($request->email);
        try{
            $bu = $user->where('email', $request->email)->count();
            if($bu <1){
                $user->create([
                    'name' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone_number'=>$request->phone_number,
                    //'password' => Hash::make($request->password),
                ]);
                return $this->registerLoginREs(1,'registerRequest',"User Registerd Successfully",$request);
            }
            else{
                return $this->registerLoginREs(0,'registerRequest',"Email Already Registerd",$request);
            }
        }catch (\Exception $e){
            return $this->registerLoginREs(0,'registerRequest',"There is error on register function 
            ".$e,$request);
        }

    }
    public function login(Request $request,User $user){
        //old code
        /*
        $password = $request->password;
        $bu = $user->where('email', $request->email)->where('password' , $password)->count();
        if($bu){
            return $this->registerLoginREs(1,'loginRequest',"Welcome",$request);
        }else{

            return $this->registerLoginREs(0,'loginRequest',"Wrong Email Or Psssword",$request);
        } // end of old code
        */
        //new code
        try{
            $userPass = $request->password;
            $truePass = $user->where('email',$request->email)->value('password');
            if(Hash::check($userPass,$truePass)){
                return $this->registerLoginREs(1,'loginRequest',"Welcome",$request);
            }else{
                return $this->registerLoginREs(0,'loginRequest',"Wrong Email Or Psssword",$request);
            }
        }catch (\Exception $e){
            return $this->registerLoginREs(0,'loginRequest',"something Wrong on login function
            ".$e,$request);
        }


    }
    // Add bind CArd Resource
    public function BindAddCardREs( $status,$requestType,$message,Request $request){
        $bindcard = new BindCard();
        $user = new User();
        if($requestType='bindCard'){
                $bindcard->status = $status;
                $bindcard->message = $message;
                return new CardResource($bindcard);
        }else{

        }
    }
    public function bindcard(Request $request,User $user,BindCard $bindCard){
        /* old code
        $password  = DB::table('users')->where('id',$request->user_id)->value('password');  // Read user password
        $qrcode  = DB::table('user_cards')->where('card_no',$request->qrcode)->value('card_no'); // Read QrCode from system  Cards    where Cards is SystemCards
        $systemCard = DB::table('cards')->where('qr_no',$request->qrcode)->value('qr_no'); // check if the Card in systems Cards Table
        if($qrcode !=null){
            return $this->BindAddCardREs( 0,'bindCard',"Card Already Binded", $request);
        }
        elseif ($password == $request->password && $systemCard ==$request->qrcode){
            $bindCard->create([
                'user_id' => $request->user_id,
                'card_no' => $request->qrcode,
            ]);
            SystemCards::where('qr_no',$request->qrcode)->delete(); //delete the card from the system
            return $this->BindAddCardREs( 1,'bindCard',"Card Add Successfully", $request);
        }
        elseif($password != $request->password){
            return $this->BindAddCardREs( 2,'bindCard',"wrong password", $request);
        }
        elseif($systemCard ==null){
            return $this->BindAddCardREs( 3,'bindCard',"Invalid Card", $request);
        }
        */
        // new code

        try{
            $password  = DB::table('users')->where('id',$request->user_id)->value('password');  // Read user password
            $qrcode  = DB::table('user_cards')->where('card_no',$request->qrcode)->value('card_no'); // Read QrCode from user  Cards
            $systemCard = DB::table('cards')->where('qr_no',$request->qrcode)->value('qr_no'); // check if the Card in systems Cards Table
            if($qrcode !=null){
                return $this->BindAddCardREs( 0,'bindCard',"Card Already Binded", $request);
            }
            elseif (Hash::check($request->password , $password) && $systemCard ==$request->qrcode){
                $bindCard->create([
                    'user_id' => $request->user_id,
                    'card_no' => $request->qrcode,
                ]);
                SystemCards::where('qr_no',$request->qrcode)->delete(); //delete the card from the system
                return $this->BindAddCardREs( 1,'bindCard',"Card Add Successfully", $request);
            }
            elseif($password != $request->password){
                return $this->BindAddCardREs( 2,'bindCard',"wrong password", $request);
            }
            elseif($systemCard ==null){
                return $this->BindAddCardREs( 3,'bindCard',"Invalid Card", $request);
            }
        }catch (\Exception $e){
            return $this->BindAddCardREs( 3,'bindCard',"something wrong in bindcard function"
                .$e, $request);
        }
    }
    public function unbindcard(Request $request,User $user,BindCard $bindCard){
        try{
            $password  = DB::table('users')->where('id',$request->user_id)->value('password');
            $qrcode  = DB::table('user_cards')->where('user_id',$request->user_id)->where('card_no',$request->qrcode)->value('card_no');
            if (Hash::check($request->password , $password)&& $qrcode ==$request->qrcode){
                //delete the card from the system
                $bindCard->where('card_no',$request->qrcode)->delete();
                return $this->BindAddCardREs( 1,'bindCard',"Card Unbinded Successfully", $request);
            } else{
                return $this->BindAddCardREs( 0,'bindCard',"Wrong Password", $request);
            }

        }catch (\Exception $e){
            return $this->BindAddCardREs( 0,'bindCard',"something Wrong in unbindCard function".$e, $request);
        }

    }
    public function getMyCards(Request $request,User $user,BindCard $bindCard){
        try{
            $user_id =  $request->user_id;
            $query = "select user_id, card_no from user_cards where user_id =".$user_id;
            $getGrages = json_encode(DB::select($query)) ;
            return $getGrages;
        }catch (\Exception $e){
            $bindcard = new BindCard();
            $bindcard->status = 0;
            $bindcard->message = "something Wrong on getMyCards function".$e;
            return new ChangeInfoResource($bindcard);
        }


    }
     public function getUserGarages(Request $request,User $user,BindCard $bindCard){


         try{
             $query_str = "SELECT parkingareas.id as garage_id, parkingareas.name as garage_name
             , parkingareas.no_of_free_slots  as  emptyslots
             , parkingareas.slots_no as slotnumbers
             ,parkingareas.lat as latitude 
             ,parkingareas.garagePhotosFolder as grageURL 
             ,parkingareas.price, parkingareas.stars
             , parkingareas.long as longitude
             , 111.045 * DEGREES(ACOS(COS(RADIANS($request->latitude)) * COS(RADIANS(parkingareas.lat))
              * COS(RADIANS(parkingareas.long) - RADIANS($request->longitude))
              + SIN(RADIANS($request->latitude)) * SIN(RADIANS(parkingareas.lat)))) AS distance
              FROM parkingareas , make_reservations 
              WHERE make_reservations.lat = parkingareas.lat and 
              make_reservations.long = parkingareas.long  and 
              user_id = $request->user_id";
             $garages = json_encode(DB::select($query_str)) ;
             return $garages;
         }catch (\Exception $e){
             $bindcard = new BindCard();
             $bindcard->status = 0;
             $bindcard->message = "something Wrong on getUserGarages function".$e;
             return new ChangeInfoResource($bindcard);
         }



    }
    /*
    public function changeInfoRes( $status,$message){
        $bindcard = new BindCard();
        if($status ==1){
            $bindcard->status = 1;
            $bindcard->message = $message;
            return new ChangeInfoResource($bindcard);
        }else{
            $bindcard->status = 0;
            $bindcard->message = $message;
            return $bindcard->toJson();
            return new ChangeInfoResource($bindcard);
        }

    }
    */
    public function ChangePassword(Request $request, User $user){
        $bindcard = new BindCard();   // creating resource for json file
        try{
            // code optimization
            $user = $user->find($request->userid); // find the user using his/ her id
            $newPass= Hash::make($request->newpassword); //encrypt new password
            $userPass = $user->where('id',$request->userid)->value('password'); //get user old password

            if(Hash::check( $request->oldpassword, $userPass)  ){// check if old pass == new pass
                if( Hash::check(  $request->newpassword , $userPass) ){
                    $bindcard->status = 0;
                    $bindcard->message = 'Enter new password';
                    return new ChangeInfoResource($bindcard);
                }
                $user->fill(['password'=> $newPass])->save();
                $bindcard->status = 1;
                $bindcard->message = ' password changed successfully';
                return new ChangeInfoResource($bindcard);
            }
            else {
                $bindcard->status = 0;
                $bindcard->message = 'Wrong password';
                return new ChangeInfoResource($bindcard);
            }
        }catch (\Exception $e){
            $bindcard->status = 0;
            $bindcard->message = 'somthing Wrong in changePassword Function'.$e;
            return new ChangeInfoResource($bindcard);
        }



        /* old Code

        $id = $request->userid;
        $current_password  = DB::table('users')->where('id',$request->userid)->value('password');
        $newPassword = $request->newpassword;
        if($current_password== $request->oldpassword){
            $current_user = User::find($id);
            if($current_user) {
                $current_user->password = $newPassword;
                $current_user->save();
            }
            $bindcard->status = 1;
            $bindcard->message = ' password changed successfully';
            return new ChangeInfoResource($bindcard);
        }
        $bindcard->status = 0;
        $bindcard->message = 'wrong password';
        return new ChangeInfoResource($bindcard);
        */
    }
    public function ChangeUsername(Request $request, User $user){
        $bindcard = new BindCard();

        try{
            $id = $request->userid;
            $current_user = User::find($id);
            if($current_user) {
                $current_user->name = $request->username;
                $current_user->save();
                $bindcard->status = 1;
                $bindcard->message = ' Name changed successfully';
                return new ChangeInfoResource($bindcard);
            }
            $bindcard->status = 0;
            $bindcard->message = 'Failed';
            return new ChangeInfoResource($bindcard);
        }catch (\Exception $e){
            $bindcard->status = 0;
            $bindcard->message = 'Failed';
            return new ChangeInfoResource($bindcard);
        }


    }
    public function changeUserEmail(Request $request, User $user){
        $bindcard = new BindCard();   // creating resource for json file
        try{
            $user = $user->find($request->userid); // find the user using his/ her id
            $userPass = $user->where('id',$request->userid)->value('password'); //get user old password
            if(Hash::check( $request->password, $userPass)  ){// check if old pass == new pass
                $user->fill(['email'=> $request->email])->save();
                $bindcard->status = 1;
                $bindcard->message = ' Email changed successfully';
                return new ChangeInfoResource($bindcard);
            }
            else {
                $bindcard->status = 0;
                $bindcard->message = 'Failed';
                return new ChangeInfoResource($bindcard);
            }
        }catch (\Exception $e){
            $bindcard->status = 0;
            $bindcard->message = 'Failed';
            return new ChangeInfoResource($bindcard);
        }

    }
    public function ChangePhoneNumber(Request $request, User $user){
        $bindcard = new BindCard();
        try{
            $id = $request->userid;
            $current_user = User::find($id);
            if($current_user) {
                $current_user->phone_number = $request->phone_number;
                $current_user->save();
                $bindcard->status = 1;
                $bindcard->message = ' Phone number changed successfully';
                return new ChangeInfoResource($bindcard);
            }
            $bindcard->status = 0;
            $bindcard->message = 'Failed';
            return new ChangeInfoResource($bindcard);
        }catch (\Exception $e){
            $bindcard->status = 0;
            $bindcard->message = 'Failed';
            return new ChangeInfoResource($bindcard);
        }
    }
    public function userProfileData(Request $request, User $user, BindCard $cards, MakeReservation $userReservatoins)
    {
        $login = new Login(); // this is user as model send to json resource
        try{
            // get user info
            $count = $user->where('id',$request->userid)->count();

            // and not have any relation with DB model
            if($count >0){
                $userName = $user->where('id',$request->userid)->value('name');      // get user Name
                $userEmail = $user->where('id',$request->userid)->value('email');    // get user Email
                $userPhoneNumber = $user->where('id',$request->userid)->value('phone_number');    // get user PhoneNumber
                $userPoints = $user->where('id',$request->userid)->value('points');    // get user Points
                $userCards = $cards->where('user_id',$request->userid)->count();       // no of cards the user have
                $userReserv = $userReservatoins->where('user_id',$request->userid)->count(); // get the number of reservations the user have
                // Set resource paramters
                $login->user_name = $userName;
                $login->status = 1;
                $login->email = $userEmail;
                $login->phone_number = $userPhoneNumber;
                $login->points = $userPoints;
                $login->no_of_cards = $userCards ==null ? 0 : $userCards;
                $login->no_of_garages = $userReserv ==null ? 0 : $userReserv;
                return new UserProfileResource($login);
            }
        }catch (\Exception $e){
            $login->status = 0;
        }

    }
    public function getGarages(Request $request, ParkingArea $parkingArea){
        /* static code  for android developer
        $bindcard = new BindCard();
        $bindcard->status = 0;
        $bindcard->message = 'wrong password';
        return new GetGaragesResource($bindcard);
        */
        // Real Code
        try{
            $query_str = "SELECT id as garage_id, name as garage_name
             , no_of_free_slots  as  emptyslots
             , slots_no as slotnumbers
             ,lat as latitude 
             ,garagePhotosFolder as grageURL 
             ,price, stars
             , parkingareas.long as longitude
             , 111.045 * DEGREES(ACOS(COS(RADIANS($request->latitude)) * COS(RADIANS(lat))
              * COS(RADIANS(parkingareas.long) - RADIANS($request->longitude))
              + SIN(RADIANS($request->latitude)) * SIN(RADIANS(lat)))) AS distance
              FROM parkingareas 
              where no_of_free_slots >= 1
               ORDER BY distance
                ASC LIMIT 0,5
            ";
            $garages = json_encode(DB::select($query_str)) ;
            return $garages;
        }catch (\Exception $e){
            $bindcard = new BindCard();   // creating resource for json file
            $bindcard->status = 0;
            $bindcard->message = 'Failed';
            return new ChangeInfoResource($bindcard);
        }

    }
    public function charge(Request $request , User $user)
    {
        try{
            $bindcard = new BindCard();
            //dd($request->toArray());
            $user_id = $request->user_id;
            $chargeAmout = $request->amount_id;
            $points= 0;
            if($chargeAmout== 1010){
                $points = 10;
            }elseif ($chargeAmout == 2525){
                $points = 25;
            }elseif ($chargeAmout == 5050){
                $points = 50;
            }elseif ($chargeAmout == 100100){
                $points = 100;
            }
            else{
                $bindcard->status = 0;
                $bindcard->message = 'You don\'t have enough Money"  or "Invaild Credit Number"  or "Failed"';
                return new ChangeInfoResource($bindcard);
            }
            $oldpoints = $user->where('id',$user_id)->value('points');
            //dd($points, $oldpoints);
            $totalPoints = $oldpoints + $points;

            $current_user = User::find($user_id);
            if($current_user) {
                $current_user->points = $totalPoints;
                $current_user->save();
                $bindcard->status = 1;
                $bindcard->message = ' Charged Successfully ';
                return new ChangeInfoResource($bindcard);
            }
        }catch (\Exception $e){
            $bindcard->status = 0;
            $bindcard->message = 'You don\'t have enough Money"  or "Invaild Credit Number"  or "Failed"';
            return new ChangeInfoResource($bindcard);
        }


    }
    public function feedback(Request $request, MessageModel $messageModel)
    {

        try {
            $bindcard = new BindCard();
            $messageModel->create([
                'user_id' => $request->user_id,
                'name' => $request->user_name,
                'message'=>$request->user_message,
            ]);
            $bindcard->status = 1;
            $bindcard->message = 'FeedBack Received successfully';
            return new ChangeInfoResource($bindcard);
        }
        catch (\Exception $e) {
            $bindcard->status = 0;
            $bindcard->message = 'Failed';
            return new ChangeInfoResource($bindcard);
        }


    }
    //rasp API
    public function CarWentOut($garag_id, $user_RFID_card_no){
        /*
           	1-read garag_id and client_rfid from request
            2-get user id using RFID from user_cards table
            3-read startTime from created_at at reservation table using user_id
            3-find the differece between current time and created_at
            4-subtract userpoints and period(assuming 1hour = 1point)
            5-update user points in users table using user_id
            6-increase no of free slots in Parkingareas table
         */
        $user_id  = DB::table('user_cards')->where('card_no',$user_RFID_card_no)->value('user_id');
        $startTimeofReservation = DB::table('make_reservations')->where('user_id',$user_id)->value('created_at');
        if($startTimeofReservation==null) return 'there was not reservation for this user';
        //caclute the time
        $to = Carbon::createFromFormat('Y-m-d H:s:i',now());
        $from = Carbon::createFromFormat('Y-m-d H:s:i', $startTimeofReservation);
        $diff_in_hours = $to->diffInHours($from);
        //if remaining minutes >30 increase hours with one
        $diff_in_min = $to->diffInMinutes($from);
        $diff_in_hours_float = (float)($diff_in_min/60);
        $rem_min = ($diff_in_hours_float-$diff_in_hours)*60;
        if($diff_in_hours>0 && $rem_min>30){
            $diff_in_hours++;
        }
        //end calculating time
        $user_points= DB::table('users')->where('id',$user_id)->value('points');
        $remained_points  = $user_points - $diff_in_hours;
        if($remained_points <0) return "the reamined points less than zero";
        // update user points field in users table
        $current_user = User::find($user_id);
        if($current_user) {
            $current_user->points =$remained_points;
            $current_user->save();
        }
        //get long and lat related to garage id
        $long  = DB::table('parkingareas')->where('id',$garag_id)->value('long');
        $lat  = DB::table('parkingareas')->where('id',$garag_id)->value('lat');
        // remove the reservation from make_reservation table
        $reservation_id= DB::table('make_reservations')->where('long',$long)
            ->where('lat',$lat)->where('user_id',$user_id)->value('id');
        $reservation = MakeReservation::find($reservation_id);
        $reservation->delete();
        //increase number of free slots for this garage
        $no_of_free_slots = DB::table('parkingareas')->where('id',$garag_id)
            ->value('no_of_free_slots');
        $no_of_free_slots++;
        $garage_slots_update=ParkingArea::find($garag_id);
        if($garage_slots_update){
            $garage_slots_update->no_of_free_slots=$no_of_free_slots;
            $garage_slots_update->save();
        }
        return 'done'; // this fuction should return nothing
    }
    public function getGarageClients($garag_id){
        /*
         * get GaragID from request
         * get long , lat related to this GaragID from parkingareas
         * apply sql query
         * encode returned data to json
        */
         $long  = DB::table('parkingareas')->where('id',$garag_id)->value('long');
         $lat  = DB::table('parkingareas')->where('id',$garag_id)->value('lat');
        $data1= DB::table('users')
            ->join('user_cards', 'users.id', '=', 'user_cards.user_id')
            ->join('make_reservations', 'user_cards.user_id', '=', 'make_reservations.user_id')
            ->where('make_reservations.long',$long)->where('make_reservations.lat',$lat)
            ->select('users.name', 'user_cards.card_no', 'make_reservations.created_at','users.points')
            ->get();
        return  GetGarageClientsResource::collection($data1);
    }
    /*
    public function test(){
        $bindcard = new BindCard();
        $cards  = DB::table('cards')->where('user_id',24)->get();
        $count  = DB::table('cards')->where('user_id',24)->count();
        $arrayvar = [];
        for($i = 0 ; $i<$count; $i++){
            $arrayvar['QR'.$i] = $cards[$i]->qrcode;
        }
        $encodedSku = json_encode($arrayvar);
        //return new testResource($arrayvar);
        return $encodedSku;
    }
    */
}
