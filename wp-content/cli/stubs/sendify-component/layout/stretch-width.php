<!--[if mso | IE]><table align="<?= $global['textAlign'] ?>" border="0" cellpadding="0" cellspacing="0" class="" style="width:<?= $global['emailMaxWidth'] ?>px;" width="<?= $global['emailMaxWidth'] ?>" bgcolor="<?= $global['background']; ?>" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
<div
    style="background:<?= $global['background']; ?>;background-color:<?= $global['background']; ?>;margin:0px auto;max-width:<?= $global['emailMaxWidth'] ?>px;">
    <table class="bg-color" align="<?= $global['textAlign'] ?>" border="0" cellpadding="0" cellspacing="0"
           role="presentation"
           style="background:<?= $global['background']; ?>;background-color:<?= $global['background']; ?>;width:100%;">
        <tbody>
        <tr>
            <td class="padding"
                style="direction:ltr;font-size:0px;padding:<?= $global['padding'] ?>px 0;text-align:<?= $global['textAlign'] ?>;">
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
