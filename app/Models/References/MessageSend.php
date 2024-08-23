<?php

namespace App\Models\References;

use DB;
use Mail;

class MessageSend
{
    /**
     * Sms uchun kirish huquqini beruvchi tokenni qaytarish
     *
     * @return mixed
     */
    public function getSmsAccessToken()
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => "notify.eskiz.uz/api/auth/login",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => array(
                    'email' => 'info@zamin.uz',
                    'password' => '4MbwqskBsN9JAM1C1af6WBsb1IJSoAWvMsT3SHPY'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response)->data->token;
    }

    /**
     * Smsni jo'natish telefon raqamga
     *
     * @param $phone
     * @param $text
     * @param $token
     * @return bool|string
     */
    public function sendSms($phone, $text, $token)
    {
        $subject = $phone;
        // $pattern_phone_number = '/^998(9[012345789]|6[125679]|7[01234569])[0-9]{7}$/';
        // $pattern_a_z = '/[a-z]$/';
        // preg_match($pattern_a_z, $subject, $matches_a_z, PREG_OFFSET_CAPTURE);
        // if (!$matches_a_z) {
        //     preg_match($pattern_phone_number, $subject, $matches__phone_number, PREG_OFFSET_CAPTURE);
        //     if ($matches__phone_number) {
                $curl = curl_init();
                curl_setopt_array(
                    $curl,
                    /*array(
                        CURLOPT_URL => "notify.eskiz.uz/api/message/sms/send",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => array('mobile_phone' => $phone, 'message' => $text),
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Bearer " . $token
                        ),
                    )*/
                    array(
                        CURLOPT_URL => "https://api.bisyor.uz/api/v1/login/sms-service",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => array('login' => '+'.$phone, 'code' => explode(': ', $text)[1], 'type' => 1),

                    )
                );
                $response = curl_exec($curl);
                curl_close($curl);
                return $response;
            //}
        //}
        return 'Error';
    }

    /**
     * Emailga xabar yuboruvchi funksiya
     *
     * @param $email
     * @param $sms_code
     * @param $_subject
     */
    public function sendMessageToEmail($email, $sms_code, $_subject)
    {
        $to_name = $email;
        $to_email = $email;
        $subject = $_subject;
        $data = array("name" => $email, "body" => $sms_code);
        try{
            Mail::send(
                "auth.email.mail",
                $data,
                function ($message) use ($to_name, $to_email, $subject) {
                    $message->to($to_email, $to_name)->subject($subject);
                    $message->from("bisyorrobot@gmail.com", "Bisyor.uz");
                }
            );
        }
        catch(\Exception $e){
            //dd($e);
            echo "<pre>";
            print_r('Sizning emailingizga sms yuborib bo\'lmadi. Chunki siz bergan email mavjud emas');
            echo "</pre>";
        }
    }
}
