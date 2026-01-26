<?php
class Config_email {

    const EMAIL_ADMIN = 'webmaster@helphp.com';
    const EMAIL_CONTACT = 'contact@helphp.com';
    const EMAIL_MAILING = 'contact@helphp.com';

    const SMTP_HOST = '';
    const SMTP_USER = '';
    const SMTP_PASS = '';
    const SMTP_SECURITY = '';
    const SMTP_PORT = '';

    const EMAIL_SIGNATURE_BODY = '<style>
* {font-family: Arial;}
table {width: 885px}
td {vertical-align: middle}
img{margin-bottom:-3px}
</style>
<table style="overflow:hidden;font-size: small; font-family: Arial; line-height:2px">
    <tr valign="top">
        <td  style="width:70px;"><p>
            <img src="cid:logo"/>
            </p>
        </td>
        <td style="font-weight:bold;width:110px;">
            <p style="font-size: 15px;margin-top:25px;">xxxxx</p>
        </td>
        <td style="width:15">
            &nbsp;<img src="cid:separator"/>
        </td>
        <td style="width:540">
            <p><img src="cid:link"/>
                &nbsp;
                <a href="">xxxxxx</a>
            </p>
            &nbsp;<a href=""><img src="cid:insta"/></a>
            &nbsp;<a href="N"><img src="cid:x"/></a>
            &nbsp;<a href=""><img src="cid:facebook"/></a>
            &nbsp;<a href="/"><img src="cid:linkedin"/></a>
        </td>
    </tr>
</table>';

    const EMBEDED = array(
        array(
            'src' => 'set an image src',
            'name' => 'logo'
        ),
        array(
            'src' => 'set an image src',
            'name' => 'separator'
        ),
        array(
            'src' => 'set an image src',
            'name' => 'link'
        ),
        array(
            'src' => 'set an image src',
            'name' => 'insta'
        ),
        array(
            'src' => 'set an image src',
            'name' => 'facebook'
        ),
        array(
            'src' => 'set an image src',
            'name' => 'linkedin'
        ),
        array(
            'src' => 'set an image src',
            'name' => 'x'
        )
    );
}
