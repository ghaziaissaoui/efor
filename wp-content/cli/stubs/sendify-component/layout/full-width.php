<table class="bg-color" align="<?= $global['textAlign'] ?>" border="0" cellpadding="0" cellspacing="0"
       role="presentation"
       style="background:<?= $global['background']; ?>;background-color:<?= $global['background']; ?>;width:100%;">
    <tbody>
    <tr>
        <td>
            <!--[if mso | IE]><table align="<?= $global['textAlign'] ?>" border="0" cellpadding="0" cellspacing="0" class="" style="width:margin:0px auto;max-width:<?= $global['emailMaxWidth'] ?>px;" width="600" bgcolor="<?= $global['background']; ?>" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
            <div style="margin:0px auto;max-width:margin:0px auto;max-width:<?= $global['emailMaxWidth'] ?>px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                       style="width:100%;">
                    <tbody>
                    <tr>
                        <td class="padding"
                            style="direction:ltr;font-size:0px;padding:<?= $global['padding'] ?>px 0px;text-align:<?= $global['textAlign'] ?>;">
                            <!--[if mso | IE]>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr><![endif]-->
                            <?php include dirname(__DIR__) . '/content.php'; ?>
                            <!--[if mso | IE]></tr></table><![endif]-->
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--[if mso | IE]></td></tr></table><![endif]-->
        </td>
    </tr>
    </tbody>
</table>
