<?php
namespace auntil;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email{
    /**
     * 执行发件
     * @param string $user 发件邮箱信息
     * @param string $email 收件箱
     * @param string $subject 邮件主题
     * @param string $text 邮件内容
     */
    public static function SendEmail($name,$user,$email,$subject,$text){
        $mail = new PHPMailer(env('app_debug',false));                              // Passing `true` enables exceptions
        try {
            //服务器配置
            $mail->CharSet ="UTF-8";                     //设定邮件编码
            $mail->SMTPDebug = 0;                        // 调试模式输出
            $mail->isSMTP();                             // 使用SMTP
            $mail->Host = $user['smtp'];                // SMTP服务器
            $mail->SMTPAuth = true;                      // 允许 SMTP 认证
            $mail->Username = $user['email'];                // SMTP 用户名  即邮箱的用户名
            $mail->Password = $user['pwd'];             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
            $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
            $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持
            $mail->setFrom($user['username'], $name);  //发件人
            $mail->addAddress($email);  // 收件人
            //$mail->addAddress('ellen@example.com');  // 可添加多个收件人
            // $mail->addReplyTo('xxxx@163.com', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致
            //$mail->addCC('cc@example.com');                    //抄送
            //$mail->addBCC('bcc@example.com');                    //密送
            //发送附件
            // $mail->addAttachment('../xy.zip');         // 添加附件
            // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 发送附件并且重命名
            //Content
            $mail->isHTML(true);                                  // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
            $mail->Subject = $subject;
            $mail->Body    = $text;
            $mail->AltBody = '请使用支持HTML的客户端查看邮件';
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
