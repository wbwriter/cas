<!--

This include file requires the following variables to be declared

$hashed_email
$subject
$message

-->


<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <style type="text/css">
        .ReadMsgBody {
            width: 100%;
            background-color: #ffffff;
        }

        .ExternalClass {
            width: 100%;
            background-color: #ffffff;
        }

        body {
            width: 100%;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            font-family: Georgia, Times, serif
        }

        table {
            border-collapse: collapse;
        }

        @media only screen and (max-width: 640px) {
            body[yahoo] .deviceWidth {
                width: 440px !important;
                padding: 0;
            }

            body[yahoo] .center {
                text-align: center !important;
            }
        }

        @media only screen and (max-width: 479px) {
            body[yahoo] .deviceWidth {
                width: 280px !important;
                padding: 0;
            }

            body[yahoo] .center {
                text-align: center !important;
            }
        }

    </style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix"
      style="font-family: Georgia, Times, serif">

<!-- Wrapper -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tbody>
    <tr>
        <td width="100%" valign="top" bgcolor="#ffffff" style="padding-top:20px">

            <!-- Start Header-->
            <table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth"
                   style="margin:0 auto;">
                <tbody>
                <tr>
                    <td width="100%" bgcolor="#ffffff">
                        <!-- Logo -->
                        <table border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
                            <tbody>
                            <tr>
                                <td style="padding:10px 20px" class="center">
                                    <a href="#"><img src="<?php echo ROOT_DIR ."img/cas_logo.PNG" ?>" alt="La cabane CAS." border="0"></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- End Logo -->

                        <!-- Nav -->
                        <table border="0" cellpadding="0" cellspacing="0" align="right" class="deviceWidth">
                            <tbody>
                            <tr>
                                <td class="center" style="font-size: 13px; color: #272727; font-weight: lighter; text-align: right; font-family: Georgia, Times, serif; line-height: 20px; vertical-align: middle; padding:10px 20px; font-style:italic">
                                    <a href="<?php echo ROOT_DIR . "sorties" ?>" style="text-decoration: none; color: #3b3b3b;">Prochaines excursions</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- End Nav -->

                    </td>
                </tr>
                </tbody>
            </table>
            <!-- End Header -->

            <!-- One Column -->
            <table width="580" class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#eeeeed" style="margin:0 auto;">
                <tbody>
                <tr>
                    <td style="font-size: 13px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px"
                        bgcolor="#eeeeed">

                        <table>
                            <tbody>
                            <tr>
                                <td valign="middle" style="padding:0 10px 10px 0"><a href="#"
                                                                                     style="text-decoration: none; color: #272727; font-size: 16px; color: #272727; font-weight: bold; font-family:Arial, sans-serif ">
                                        <?php echo $subject ?></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?php echo $message ?>
                    </td>
                </tr>

                <tr>
                    <td style="font-size: 12px; color: #959595; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px"
                        bgcolor="#eeeeed">
                        <a href="<?php echo 'localhost/cas/newsletter/unsubscribe/'.$hashed_email ?>">Unsubscribe from the newsletter</a>
                    </td>
                </tr>

                </tbody>
            </table>
    </tbody>
</table>
<!-- End Wrapper -->

</body>
</html>