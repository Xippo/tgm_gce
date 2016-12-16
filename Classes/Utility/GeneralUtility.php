<?php
namespace TGM\TgmGce\Utility;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class GeneralUtility {

    /**
     * Sendet eine E-Mail
     *
     * @param string $from E-Mail Adresse
     * @param mixed $to E-Mail Adressen komma separiert oder array mit E-Mail Adressen
     * @param string $subject
     * @param string $mailContent
     */
    public static function sendMail($from,$to,$subject,$mailContent){
        /** @var \TYPO3\CMS\Core\Mail\MailMessage $mail */
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Mail\MailMessage');
        $mail->setFrom($from);
        if(count($to)>0){
            $mail->setTo($to);
        }else{
            $mail->setTo(explode(',',$to));
        }
        $mail->setSubject($subject);
        $mail->setContentType('text/html');
        $mail->setBody($mailContent);
        $mail->send();
        return $mail->isSent();
    }
}
