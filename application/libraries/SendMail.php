<?php if(!defined('BASEPATH')) exit('No Direct Script Acceess');
class SendMail{
    public function send_email($subject, $to, $form, $msg, $data = '', $altMsg = '', $template = '') {
        require APPPATH . "libraries/phpmailer/PHPMailerAutoload.php";
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        $error = '';
        try {
            if ($form != '') {
                $mail->setFrom($form, $form);
                $mail->addReplyTo($form, $form);
            } else {
                $mail->setFrom('support@mysawari.com', 'MySawari');
                $mail->addReplyTo('support@mysawari.com', 'MySawari');
            }

            $html_view = (($template != '') ? $template : 'default_email');
            $template = 'email_template/' . $html_view;
            $CI = & get_instance();
            $body = $CI->load->view($template, array('msg' => $msg, 'data' => $data), true);

            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = (($altMsg != '') ? $altMsg : $msg);
            $mail->send();
            $error .= 'Email Sent Successfully ! ';
        } catch (Exception $e) {
            $error .= 'Message could not be sent.';
            $error .= 'Mailer Error: ' . $mail->ErrorInfo;
        }
        return $error;
    }
}
