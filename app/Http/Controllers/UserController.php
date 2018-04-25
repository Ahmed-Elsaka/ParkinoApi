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
use App\Login;
use App\SystemCards;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class UserController extends Controller
{

    // Phone API
    // Resource function
    public function registerLoginREs( $status,$requestType,$message,Request $request){
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
        $bu = $user->where('email', $request->email)->count();
        if($bu <1){
            $user->create([
                'name' => $request->username,
                'email' => $request->email,
                'password' => $request->password,
                'phone_number'=>$request->phone_number,
                //'password' => Hash::make($request->password),
            ]);
            return $this->registerLoginREs(1,'registerRequest',"User Registerd Successfully",$request);
        }
        else{
            return $this->registerLoginREs(0,'registerRequest',"Email Already Registerd",$request);
        }
    }
    public function login(Request $request,User $user){
        $password = $request->password;
        $bu = $user->where('email', $request->email)->where('password' , $password)->count();
        if($bu){
            return $this->registerLoginREs(1,'loginRequest',"Welcome",$request);
        }else{

            return $this->registerLoginREs(0,'loginRequest',"Wrong Email Or Psssword",$request);
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
        // Read user password
        $password  = DB::table('users')->where('id',$request->user_id)->value('password');
        // Read QrCode from system  Cards    where Cards is SystemCards
        $qrcode  = DB::table('user_cards')->where('card_no',$request->qrcode)->value('card_no');
        // check if the Card in systems Cards Table
        $systemCard = DB::table('cards')->where('qr_no',$request->qrcode)->value('qr_no');

       // dd($password, $qrcode, $systemCard);
        if($qrcode !=null){
            return $this->BindAddCardREs( 0,'bindCard',"Card Already Binded", $request);
        }
        elseif ($password == $request->password && $systemCard ==$request->qrcode){
            //add the card to user

            $bindCard->create([
                'user_id' => $request->user_id,
                'card_no' => $request->qrcode,
            ]);
            //delete the card from the system
            SystemCards::where('qr_no',$request->qrcode)->delete();
            return $this->BindAddCardREs( 1,'bindCard',"Card Add Successfully", $request);
        }
        elseif($password != $request->password){
            return $this->BindAddCardREs( 2,'bindCard',"wrong password", $request);
        }
        elseif($systemCard ==null){
            return $this->BindAddCardREs( 3,'bindCard',"Invalid Card", $request);
        }


    }
    public function unbindcard(Request $request,User $user,BindCard $bindCard){
        $password  = DB::table('users')->where('id',$request->user_id)->value('password');
        $qrcode  = DB::table('user_cards')->where('user_id',$request->user_id)->where('card_no',$request->qrcode)->value('card_no');
        if ($password == $request->password && $qrcode ==$request->qrcode){
            //delete the card from the system
             $bindCard->where('card_no',$request->qrcode)->delete();
            return $this->BindAddCardREs( 1,'bindCard',"Card Unbinded Successfully", $request);
        } else{
            return $this->BindAddCardREs( 0,'bindCard',"Failed To Unbind Card", $request);
        }

    }
    public function getMyCards(Request $request,User $user,BindCard $bindCard){
       // return 'ahmed';
       // $user_id = $request->header('user_id');
       $user_id =  $request->user_id;
       // return 'ahmed'.$user_id. ' '. $request->name;
       // $var = $request->header()['user-id'];
        //$user_id = $request->headers->get('user_id'); // will send me user_id in header
        $cards  = DB::table('user_cards')->where('user_id',$user_id)->get()->toJson();
       // type to return the values of qr code only ;
        return ($cards);

    }
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
    public function ChangePassword(Request $request, User $user){
        $bindcard = new BindCard();
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

    }
    public function ChangeUsername(Request $request, User $user){
        $bindcard = new BindCard();
        $id = $request->userid;
        $current_password  = DB::table('users')->where('id',$request->userid)->value('password');
        $password = $request->password;
        if($current_password== $password){
            $current_user = User::find($id);
            if($current_user) {
                $current_user->name = $request->username;
                $current_user->save();
            }
            $bindcard->status = 1;
            $bindcard->message = ' Name changed successfully';
            return new ChangeInfoResource($bindcard);
        }
        $bindcard->status = 0;
        $bindcard->message = 'wrong password';
        return new ChangeInfoResource($bindcard);

    }
    public function ChangePhoneNumber(Request $request, User $user){
        $bindcard = new BindCard();
        $id = $request->userid;
        $current_password  = DB::table('users')->where('id',$request->userid)->value('password');
        $password = $request->password;
        if($current_password== $password){
            $current_user = User::find($id);
            if($current_user) {
                $current_user->phone_number = $request->phone_number;
                $current_user->save();
            }
            $bindcard->status = 1;
            $bindcard->message = ' Phone number changed successfully';
            return new ChangeInfoResource($bindcard);
        }
        $bindcard->status = 0;
        $bindcard->message = 'wrong password';
        return new ChangeInfoResource($bindcard);

    }
    public function getGarages(){
        $bindcard = new BindCard();
        $bindcard->status = 0;
        $bindcard->message = 'wrong password';
        return new GetGaragesResource($bindcard);
    }
    //rasp API
    public function CarWentOut($garage_id, $RFID_card){
        //dd($garage_id, $RFID_card);

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

        /* pure sql command
        $data=  DB::select(
            DB::raw(
                "SELECT name as firstName,
                    card_no as RFID ,
                    make_reservations.created_at as reservationTime,
                    points as maxHours 
                  FROM users, user_cards, make_reservations
                   where users.id = user_cards.user_id 
                   AND user_cards.user_id = make_reservations.user_id 
                   AND make_reservations.long=1230 and make_reservations.lat=1230"));

        */
        $data1= DB::table('users')
            ->join('user_cards', 'users.id', '=', 'user_cards.user_id')
            ->join('make_reservations', 'user_cards.user_id', '=', 'make_reservations.user_id')
            ->where('make_reservations.long',$long)->where('make_reservations.lat',$lat)
            ->select('users.name', 'user_cards.card_no', 'make_reservations.created_at','users.points')
            ->get();
        return  GetGarageClientsResource::collection($data1);
    }
















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

}
