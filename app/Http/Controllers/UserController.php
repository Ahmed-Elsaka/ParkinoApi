<?php

namespace App\Http\Controllers;
use App\BindCard;
use App\grageSlotsModel;
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
use App\OwnerModel;
use App\ParkingArea;
use App\SystemCards;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use phpDocumentor\Reflection\Types\Null_;
use app\help;

class UserController extends Controller
{
    // Phone API
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
        //inputs [username, email, password, phone_number]
        try{
            $bu = $user->where('email', $request->email)->count();
            if($bu <1){
                $user->create([
                    'name' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone_number'=>$request->phone_number,
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

    } //[ Tested ]
    public function login(Request $request,User $user){
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


    } //[ Tested]
    public function BindAddCardREs( $status,$requestType,$message,Request $request){
        // this is bind card resource
        $bindcard = new BindCard();
        $user = new User();
        if($requestType='bindCard'){
                $bindcard->status = $status;
                $bindcard->message = $message;
                return new CardResource($bindcard);
        }else{

        }
    } // [ Tested ]
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

        /* inputs [user_id, password, qrcode]
         * scenario:
         *  1- check if the password correct
         *  2- check if the qrcode already in the system or not and get relative RFID number
         *  3- check if the state of QrCode not used before and if the card no in the system or not
         *  4- add this card to user_cards and change the state of this card to 1 [used bedore]
         */
        try{
            $userPassword  = DB::table('users')->where('id',$request->user_id)->value('password');  // Read user password
            // 1- check if the password is correct
            if(Hash::check($request->password,$userPassword)){
                // 2- check if the card exist in the system or not
                $systemCard = DB::table('cards')->where('qr_no',$request->qrcode)->value('qr_no'); // check if the Card in systems Cards Table
                if($systemCard ==null){ // the card is not in the system
                    return $this->BindAddCardREs( 3,'bindCard',"Invalid Card", $request);
                }else{ // the card is in the system
                    // check if the card has been used before
                    $cardState = $systemCard = DB::table('cards')->where('qr_no',$request->qrcode)->value('state');
                    if($cardState == 0){ // the card has not used before
                        $RFID_no = DB::table('cards')->where('qr_no',$request->qrcode)->value('rfid_no');  // get RFID no related to this Qrcode
                        // add the used to user
                        $bindCard->create([
                            'user_id' => $request->user_id,
                            'card_no' => $RFID_no,
                        ]);
                        // change the state of the card to be used
                        SystemCards::where('qr_no', $request->qrcode)->update(['state' => 1]);
                        return $this->BindAddCardREs( 1,'bindCard',"This card has been add successfully", $request);

                    }else{ // the card has been used before
                        return $this->BindAddCardREs( 0,'bindCard',"this card has been used before", $request);
                    }
                }
            }else{
                return $this->BindAddCardREs( 2,'bindCard',"Wrong Password", $request);
            }

        }catch (\Exception $e){
            return $this->BindAddCardREs( 3,'bindCard',"something wrong in bindcard function"
                .$e, $request);
        }
    } // [ Tested ]
    public function unbindcard(Request $request,User $user,BindCard $bindCard){
        /*
         * inputs [user_id, password, card_id(RFID_NO)]
         * Scenario:
         *  - the user select from his/her cards from mobile application :
         *      1- check if the password correct :
         *          YES: delete the card from user cards
         *          NO : tell him/her wrong password
         */
        try{
            $userPassword  = DB::table('users')->where('id',$request->user_id)->value('password'); // get user password
            $count = MakeReservation::where('RFID_no',$request->qrcode)->where('user_id',$request->user_id)->count();
            if($count >0){
                return $this->BindAddCardREs( 0,'bindCard',"Already used", $request);
            }else{
                if (Hash::check($request->password , $userPassword)){ // the password is correct
                    // check if the card owned by this user
                    $RFID_no  = DB::table('user_cards')->where('user_id',$request->user_id)->where('card_no',$request->qrcode)->value('card_no');
                    if($RFID_no != null){  // the user own this card
                        //delete the card from the system
                        $bindCard->where('card_no',$RFID_no)->delete();
                        return $this->BindAddCardREs( 1,'bindCard',"Card Unbinded Successfully", $request);
                    }else{ // this card not owned by this user
                        return $this->BindAddCardREs( 0,'bindCard',"Invalid Card Number", $request);
                    }
                } else{
                    return $this->BindAddCardREs( 0,'bindCard',"Wrong Password", $request);
                }
            }
            if (Hash::check($request->password , $userPassword)){ // the password is correct
                // check if the card owned by this user
                $RFID_no  = DB::table('user_cards')->where('user_id',$request->user_id)->where('card_no',$request->qrcode)->value('card_no');
                if($RFID_no != null){  // the user own this card
                    //delete the card from the system
                    $bindCard->where('card_no',$RFID_no)->delete();
                    return $this->BindAddCardREs( 1,'bindCard',"Card Unbinded Successfully", $request);
                }else{ // this card not owned by this user
                    return $this->BindAddCardREs( 0,'bindCard',"Invalid Card Number", $request);
                }
            } else{
                return $this->BindAddCardREs( 0,'bindCard',"Wrong Password", $request);
            }

        }catch (\Exception $e){
            return $this->BindAddCardREs( 0,'bindCard',"something Wrong in unbindCard function".$e, $request);
        }

    } //[ Tested ]
    public function ChangePassword(Request $request, User $user){
        /*
         * inputs [userid,oldpassword,password]
         * Scenario:
         *  1- Check if the password correct :
         *      NO: tell him wrong password
         *      YES: check if old password == new password :
         *          NO : change password
         *          YES : tell him to change the password because is the same old password
         */



        $bindcard = new BindCard();   // creating resource for json file
        try{
            $userPass = $user->where('id',$request->userid)->value('password'); //get user old password
            //dd($userPass);
            $user = $user->find($request->userid); // find the user using his/ her id
            if(Hash::check($request->oldpassword, $userPass)  ){// check if old pass == new pass
                if( Hash::check($request->newpassword , $userPass) ){
                    $bindcard->status = 0;
                    $bindcard->message = 'Enter new password';
                    return new ChangeInfoResource($bindcard);
                }else{
                    $newPass= Hash::make($request->password); //encrypt new password
                    $user->where('id',$request->userid)->update(['password'=> $newPass]); // change the password
                    $bindcard->status = 1;
                    $bindcard->message = ' password changed successfully';
                    return new ChangeInfoResource($bindcard);
                }
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
    }  //[ Tested ]
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
                $user_email = $user->where('email',$request->email)->count();
                if($user_email>0){
                    $bindcard->status = 0;
                    $bindcard->message = ' Email Already used';
                    return new ChangeInfoResource($bindcard);
                }
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
              ,make_reservations.slot
             ,make_reservations.RFID_no as card_id
             ,make_reservations.annually_tier
             ,make_reservations.monthly_tier
             ,make_reservations.daily_tier
             ,make_reservations.hourly_tier
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
            } else{
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
            /* if the user who charged have records in reservation table
               i should update user points in rasp ;
           */
            $no_of_records = MakeReservation::where('user_id',$user_id)->count();
            if($no_of_records > 0 ){
                // udpate no of points on Rasp ;
                $client = new Client();
                $client->request('GET', '127.0.0.1:8000/api/test/'.$totalPoints);

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
    public function reserveSlot(Request $request, MakeReservation $makeReservation)
    {
        /*
         * inputs [ garage_id, user_id,password,user_rfid, reserve_type]
         *  0- check user password
         *  1- check if the use has no points -> tell him/her you must charge first
         *  2- get free slot from GragesSlots Table and change it is state to 0 (busy);
         *  3- insert reservation in reservation table
         *  4- increase no of free slots on parkingArea Table
         * NOTES:
         *      Garage Slots start from 0 index
         *
         */
        // 0- check user password
        $user = User::find($request->user_id);
        $points = $user->points;
        $bindcard = new BindCard();  // just a model for json
        $userPass = $user->where('id',$request->user_id)->value('password'); //get user old password
        if(Hash::check( $request->password, $userPass)  ) {// check if old pass == new pass
            // check if the user has this card
            $card_test = DB::table('user_cards')->where('card_no',$request->user_rfid)->count();
            if($card_test > 0 ){
                // check if user has enough points to charge
                if ($points < 1) {
                    // you should charge
                    $bindcard->status = 0;
                    $bindcard->message = "you don't have enough balance , you should charge";
                    return new ChangeInfoResource($bindcard);
                }
                else {
                    // 2- get free slot from GragesSlots Table and change it is state to 0 (busy);
                    $slot_id = grageSlotsModel::where('garage_id', $request->garage_id)->where('state', 1)->value('id');
                    $slot = grageSlotsModel::find($slot_id);
                    $slot->state = 0; // make this slot busy ;
                    $slot_num = $slot->slot;  // reserved slot number ;
                    $slot->save();
                    // 3- insert reservation in reservation table
                    $long = ParkingArea::where('id', $request->garage_id)->value('long');
                    $lat = ParkingArea::where('id', $request->garage_id)->value('lat');
                    $reservation_type = $request->reserve_type; // for hours mode
                    $hourly_tire = 0;
                    $monthly_tire = 0;
                    $annually_tire = 0;
                    $daily_tire = 0;
                    if ($reservation_type == "111") { // hourly mode
                        $hourly_tire = 1;
                    } elseif ($reservation_type == "333") {// monthly mode
                        $monthly_tire = 1;
                    } elseif ($reservation_type == "444") {// annually mode
                        $annually_tire = 1;
                    } elseif ($reservation_type == "222") {// daily mode
                        $daily_tire = 1;
                    }
                    $makeReservation->create([
                        'long' => $long,
                        'lat' => $lat,
                        'user_id' => $request->user_id,
                        'annually_tier' => $annually_tire,
                        'monthly_tier' => $monthly_tire,
                        'daily_tier' => $daily_tire,
                        'hourly_tier' => $hourly_tire,
                        'state' => 0, // indicate the slot is not locked
                        'RFID_no' => $request->user_rfid,
                        'slot' =>$slot_num
                    ]);
                    // update no of free slots in parking area
                    //decrease number of free slots for this garage
                    $no_of_free_slots = DB::table('parkingareas')->where('id',$request->garage_id)
                        ->value('no_of_free_slots');
                    $no_of_free_slots--;
                    $garage_slots_update=ParkingArea::find($request->garage_id);
                    if($garage_slots_update){
                        $garage_slots_update->no_of_free_slots=$no_of_free_slots;
                        $garage_slots_update->save();
                    }
                    $bindcard->status = 1;
                    $bindcard->message = "Garage reserved successfully";
                    return new ChangeInfoResource($bindcard);
                }
            }else{
                $bindcard->status = 0;
                $bindcard->message = "invalid Card";
                return new ChangeInfoResource($bindcard);
            }
        }else{
            $bindcard->status = 0;
            $bindcard->message = "Wrong Password";
            return new ChangeInfoResource($bindcard);
        }
    }
    public function searchForGarage(Request $request)
    {
        $name = $request->Search_text;
        $query_str = "SELECT id as garage_id, name as garage_name
             , no_of_free_slots  as  emptyslots
             , slots_no as slotnumbers
             ,parkingareas.lat as latitude 
             ,garagePhotosFolder as grageURL
             ,price, stars
             , parkingareas.long as longitude
             , 111.045 * DEGREES(ACOS(COS(RADIANS($request->latitude)) * COS(RADIANS(lat))
              * COS(RADIANS(parkingareas.long) - RADIANS($request->longitude))
              + SIN(RADIANS($request->latitude)) * SIN(RADIANS(lat)))) AS distance
              FROM parkingareas 
              where   parkingareas.name LIKE '%$name%' and  no_of_free_slots >= 1 
               ORDER BY distance
                ASC LIMIT 0,5
            ";
        $garages = json_encode(DB::select($query_str)) ;
        return $garages;
    } //[ Tested ]
    public function CancelReservation($cancelled_reservations_slots ){ // Automatic

        // print('iam in cancel Reservation');
        // this function automatic Cancel Reservation when points finished;

        /*
        * ask ibrahim if the car in ?
        * yes : do nothing
        * no : cancel reservation and make the slot free
        */
        // cancel reservation because the car is not in and tell ibrahim the reservation
        // is cancelled0

      //  $result = (string)$cancelled_reservations;

        // get slots if this ids
        // send this slots to rasp to tell you if this slots used or not
        // if slots used => do nothing else cancel reservation

       // send post request with slots

        $url = $this->GetRaspUrl().'IsInside';//API Url
        $ch = curl_init($url);//Initiate cURL.
        $jsonDataEncoded = json_encode( [
            'slot' => $cancelled_reservations_slots
        ]);//Encode the array into JSON.
        curl_setopt($ch, CURLOPT_POST, 1);//Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));//Set the content type to application/json
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch); // EXECUTE:
        if(!$result){
            $bindcard = new BindCard();
            $bindcard->status = 0;
            $bindcard->message = "Connection Failure";
        }
        $data = json_decode($result,true);
        //dd($data['status'][0],$data,'size of data = '.sizeof($data),'size of status '.sizeof($data['status']));
        curl_close($ch);

       $status = $data['status'];
       //print ('returned from IsInside');
      // print_r($status);
        $array_length = sizeof($data['status']);
        $slots_cancelled = array();  // cancel these slots from garage
        for($i = 0 ; $i < $array_length ; $i++){
            if($status[$i] == "1"){ // the car in
                    // do nothing
            }elseif($status[$i] == "0"){ // the car out
                    $user_id  = MakeReservation::where('slot',$cancelled_reservations_slots[$i])->value('user_id'); // user id
                    $reservation_id = MakeReservation::where('slot',$cancelled_reservations_slots[$i])->value('id');
                    //1- take balance
                    $Curr_user = User::find($user_id);
                    $Curr_user->points = $Curr_user->points - $Curr_user->consumed_points ;
                    $Curr_user->consumed_points = 0 ;
                    $Curr_user->save();
                    //2- Cancel Reservation
                    $res = MakeReservation::find($reservation_id);
                    $res->state = 1;   // indicate the reservation is canceled
                    $slot_num = $res->slot;
                    $res->save();
                    // 3 - make reserved slot is free
                    // get long and lat
                    $long =MakeReservation::where('id',$reservation_id)->value('long');
                    $lat =MakeReservation::where('id',$reservation_id)->value('lat');
                    // get garage ID
                    $grage_id = ParkingArea::where('long',$long)->where('lat',$lat)->value('id');
                    // change the state of slot in GragesSlots table
                    $slot_id = grageSlotsModel::where('garage_id',$grage_id)->where('slot',$slot_num)->value('id');
                    $slot = grageSlotsModel::find($slot_id);
                    $slot->state = 1;  // indicate it is free;
                    $slot->save();
                    //4- TEll RAsp to Cancel reservation
                    // send to Rasp to cancel reservation [remove]
                    array_push($slots_cancelled,$slot_num);
                    // echo (string)$res->getBody();
            }
        }

        $array_length = sizeof($slots_cancelled);
        if($array_length > 0){  // send request only if there are free slots
            // send the slots you want to cancel to rasp
            $url = $this->GetRaspUrl().'remove';//API Url
            $ch = curl_init($url);//Initiate cURL.
            $jsonDataEncoded = json_encode( [
                'slot' => $slots_cancelled
            ]);//Encode the array into JSON.
            curl_setopt($ch, CURLOPT_POST, 1);//Tell cURL that we want to send a POST request.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));//Set the content type to application/json
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // time out
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
            $result = curl_exec($ch); // EXECUTE:
            if(!$result){die("Connection Failure");}
            $data = json_decode($result,true);
            //dd($data['status'][0],$data,'size of data = '.sizeof($data),'size of status '.sizeof($data['status']));
            curl_close($ch);
            // delete reservation from table
            for($i = 0 ; $i < $array_length ; $i++){
                // delete reservation
                $reserve_id = MakeReservation::where('slot',$slots_cancelled[$i])->delete();
                //increase number of free slots for this garage
                $no_of_free_slots = DB::table('parkingareas')->where('id',$grage_id)
                    ->value('no_of_free_slots');
                $no_of_free_slots++;
                $garage_slots_update=ParkingArea::find($grage_id);
                if($garage_slots_update){
                    $garage_slots_update->no_of_free_slots=$no_of_free_slots;
                    $garage_slots_update->save();
                }

            }
        }

    } //Automatic Cancellation
    public function phoneCancellation( Request $request)
    {


        /*
         * inputs [garage_id, user_id, slot_num, password]
         * Scenario
         * 1 - check if password is correct :
         *  NO : tell user to re inter correct password
         *  YES :
         *      Ask the garage if the care in :
         *          yes :
         *               2- check if the user have enough points :
         *               NO : tell uesr to recharge to cancel reservation
         *               YES : send slot no to cancelReservation Method on garageRasp
         *          no :
         *              calulate the required points and cancel reservation
         */
        $user_password = User::where('id',$request->user_id)->value('password');
        $bindcard = new BindCard();  // just for resource
        if(Hash::check($request->password,$user_password)){ // check if password is correct
            // ask if the car in

            $slot = array($request->slot_num);

            $url = $this->GetRaspUrl().'IsInside';//API Url
            $ch = curl_init($url);//Initiate cURL.
            $jsonDataEncoded = json_encode( [
                'slot' => $slot
            ]);//Encode the array into JSON.
            curl_setopt($ch, CURLOPT_POST, 1);//Tell cURL that we want to send a POST request.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//Attach our encoded JSON string to the POST fields.
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));//Set the content type to application/json
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // time out
            curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
            $result = curl_exec($ch); // EXECUTE:

            if(!$result){
                $bindcard = new BindCard();
                $bindcard->status = 0;
                $bindcard->message = ' connection Faild';
                return new ChangeInfoResource($bindcard);
            }
            $data = json_decode($result,true);
            //dd($data['status'][0],$data,'size of data = '.sizeof($data),'size of status '.sizeof($data['status']));
            curl_close($ch);

            $result = $data['status'];
            $bindcard = new BindCard();
            if($result[0] == "1"){  // the car is in
                // calculate required points to cancel reservation
                $long = ParkingArea::where('id',$request->garage_id)->value('long');
                $lat = ParkingArea::where('id',$request->garage_id)->value('lat');
                $startTimeofReservation = DB::table('make_reservations')->where('user_id',$request->user_id)->where('slot',$request->slot_num)
                    ->where('long',$long)->where('lat',$lat)->value('created_at');
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
                if($diff_in_hours ==0 ) $diff_in_hours =1;
                $user_points= DB::table('users')->where('id',$request->user_id)->value('points');
                $remained_points  = $user_points - $diff_in_hours;
                if($remained_points <= 0){
                    // the user should recharge points
                    $bindcard->status = 0;
                    $bindcard->message = 'Please charge ';
                    return new ChangeInfoResource($bindcard);

                }else{ // send the request to rasp to open slot
                    $url = '192.168.1.15:8000/test';//API Url
                    $ch = curl_init($url);//Initiate cURL.
                    $jsonDataEncoded = json_encode( [
                        'slot' => $request->slot_num
                    ]);//Encode the array into JSON.
                    curl_setopt($ch, CURLOPT_POST, 1);//Tell cURL that we want to send a POST request.
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//Attach our encoded JSON string to the POST fields.
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));//Set the content type to application/json
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // time out
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
                    $result = curl_exec($ch); // EXECUTE:
                    if(!$result){

                        $bindcard = new BindCard();
                        $bindcard->status = 0;
                        $bindcard->message = "Connection Failure";
                        return new ChangeInfoResource($bindcard);
                    }
                    $data = json_decode($result,true);
                    //dd($data['status'][0],$data,'size of data = '.sizeof($data),'size of status '.sizeof($data['status']));
                    curl_close($ch);

                    $bindcard->status = 1;
                    $bindcard->message = 'Press on push button during 5 min';
                    return new ChangeInfoResource($bindcard);
                }
            }else{  // car out
                // calculate required points to cancel reservation
                $long = ParkingArea::where('id',$request->garage_id)->value('long');
                $lat = ParkingArea::where('id',$request->garage_id)->value('lat');
                $startTimeofReservation = DB::table('make_reservations')->where('user_id',$request->user_id)->where('slot',$request->slot_num)
                    ->where('long',$long)->where('lat',$lat)->value('created_at');
                //if($startTimeofReservation==null) return 'there was not reservation for this user';
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
                $user_points= DB::table('users')->where('id',$request->user_id)->value('points');
                $remained_points  = $user_points - $diff_in_hours;
                // update user points field in users table
                $current_user = User::find($request->user_id);
                if($current_user) {
                    $current_user->points =$remained_points;
                    $current_user->save();
                }
                // update garage points for owner
                $garage_points = OwnerModel::where('garage_id',$request->garage_id)->value('garage_points');
                $garage_points +=$diff_in_hours;
                OwnerModel::where('garage_id',$request->garage_id)->update(['garage_points'=> $garage_points]);
                // remove the reservation from make_reservation table
                $reservation_id= DB::table('make_reservations')->where('long',$long)
                    ->where('lat',$lat)->where('user_id',$request->user_id)
                    ->where('slot',$request->slot)->delete(); // changed value('id') => delete()
                //$reservation = MakeReservation::find($reservation_id);
               // $reservation->delete();
                // tell the rasp to delete this reservation from its database

                $url = $this->GetRaspUrl().'remove';//API Url
                $ch = curl_init($url);//Initiate cURL.
                $jsonDataEncoded = json_encode( [
                    'slot' => $request->slot
                ]);//Encode the array into JSON.
                curl_setopt($ch, CURLOPT_POST, 1);//Tell cURL that we want to send a POST request.
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//Attach our encoded JSON string to the POST fields.
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));//Set the content type to application/json
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // time out
                curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
                $result = curl_exec($ch); // EXECUTE:
                if(!$result){

                    $bindcard = new BindCard();
                    $bindcard->status = 0;
                    $bindcard->message = "Connection Failure";
                    return new ChangeInfoResource($bindcard);
                }
                $data = json_decode($result,true);
                //dd($data['status'][0],$data,'size of data = '.sizeof($data),'size of status '.sizeof($data['status']));
                curl_close($ch);

                //increase number of free slots for this garage
                $no_of_free_slots = DB::table('parkingareas')->where('id',$request->garage_id)
                    ->value('no_of_free_slots');
                $no_of_free_slots++;
                $garage_slots_update=ParkingArea::find($request->garage_id);
                if($garage_slots_update){
                    $garage_slots_update->no_of_free_slots=$no_of_free_slots;
                    $garage_slots_update->save();
                }
                // change the state of slot in GragesSlots table
                $slot_id = grageSlotsModel::where('garage_id',$request->garage_id)->where('slot',$request->slot_num)->value('id');
                $slot = grageSlotsModel::find($slot_id);
                $slot->state = 1;  // indicate it is free ;
                $slot->save();
            }
        }else{
            $bindcard->status = 0;
            $bindcard->message = 'Wrong password';
            return new ChangeInfoResource($bindcard);
        }
    } // cancellation from the phone

    // RAsp API :
    public function getNewReservations(Request $request, ParkingArea $parkingArea, grageSlotsModel $grageSlotsModel, MakeReservation $makeReservation)
    {
        $garage_id = $request->ID;

        $long =$parkingArea->where('id',$garage_id)->value('long');
        $lat = $parkingArea->where('id',$garage_id)->value('lat');
        $query = "select  users.name,make_reservations.RFID_no as RFID , make_reservations.slot from users
                  , make_reservations where users.id = make_reservations.user_id and make_reservations.long=".$long."
                   and make_reservations.lat=".$lat. " and  make_reservations.state = 0";

        /*
        $query = "select  users.name, users.points as Hours ,
                  make_reservations.slot,make_reservations.RFID_no, make_reservations.created_at as startTime from users
                  , make_reservations where users.id = make_reservations.user_id and make_reservations.long=".$long."
                   and make_reservations.lat=".$lat. " and  make_reservations.state = 0";
        */
        $data = DB::select($query);
        $n= count($data);
        //update state of returned rows
        for( $i = 0 ; $i < $n ; $i++){
            MakeReservation::where('slot', $data[$i]->slot)
                ->where('RFID_no', $data[$i]->RFID)
                ->update(['state' => 1]);  // must set it to one
        }
        $newReserved = json_encode($data) ;
        return $newReserved;
    }
    public function raspCancellation(Request $request)
    {
        // get user id from RFID_no
        print_r($request->toArray());
        $garag_id = $request->GARAGEID;
        $user_RFID_card_no = $request->RFID ;
        $slot = $request->slot;
        $user_id  = DB::table('user_cards')->where('card_no',$user_RFID_card_no)->value('user_id');
        $long = ParkingArea::where('id',$garag_id)->value('long');
        $lat = ParkingArea::where('id',$garag_id)->value('lat');
        $startTimeofReservation = DB::table('make_reservations')->where('user_id',$user_id)->where('slot',$slot)
            ->where('long',$long)->where('lat',$lat)->value('created_at');
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
        if($diff_in_hours ==0 ) $diff_in_hours =1;
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
        // change the state of slot in GragesSlots table
        $slot_id = grageSlotsModel::where('garage_id',$garag_id)->where('slot',$slot)->value('id');
        $slot = grageSlotsModel::find($slot_id);
        $slot->state = 1;  // indicate it is free ;
        $slot->save();

        // 5- delete reservation
        $reservation_id = MakeReservation::where('RFID_no',$user_RFID_card_no)->where('slot',$slot)->delete();
        return 'deleted successfully';

    } //[ Not tested by rasb ]
    // For Testing
    public function test( Request $request){

        $ip = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
        return $ip;
        $url = 'http://192.168.1.15:6000/api/testGuzzel';//API Url
        $ch = curl_init($url);//Initiate cURL.
        //The JSON data.
        $jsonData = array(
            'username' => 'Fuck you',
            'password' => 'Elsaka'
        );
        $jsonDataEncoded = json_encode(['slots' => $jsonData]);//Encode the array into JSON.
        curl_setopt($ch, CURLOPT_POST, 1);//Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);//Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));//Set the content type to application/json
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // time out
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch); // EXECUTE:
        if(!$result){
            $bindcard = new BindCard();
            $bindcard->status = 0;
            $bindcard->message = "Connection Failure";
        }
        $data = json_decode($result,true);
       // dd($data);
        //dd($data['status'][0],$data,'size of data = '.sizeof($data),'size of status '.sizeof($data['status']));
        curl_close($ch);
        return $data;


    }
    public function testGuzzel(Request $request){
      //  print('im in testGuzzel');
        return (json_encode($request->toArray()));
        $bindcard = new BindCard();
        $bindcard->status = array(2,3,2,2);
        $bindcard->message = ' Name changed successfully';
        return new ChangeInfoResource($bindcard);

    }

    // public URLS
    public function GetRaspUrl(){
        return '102.185.69.74:5000/api/';
    }
    public function getSlotsRasp(){
        return '102.185.69.74:5001/api/';
    }


}
