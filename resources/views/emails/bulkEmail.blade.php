<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        @font-face {
            font-family: 'SFProText';
            src: url({{asset('assets/font/FontsFree-Net-SFProText-Regular.ttf')}}) format('truetype');
        }
        * {
            font-family:SFProText !important;
        }
        #artboard {
            width: 60%;
        }
    </style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <img id="artboard" src="{{asset('assets/img/Artboard1.jpg')}}" />
    <p>Dear SLAM Member!  ❤️ </p>
    
    <p>We are very grateful to have you among our family and have your support on our side.</p>

    <p>Therefore we are very excited to inform you that we are only 1 day away from the big awaited day, the day of Diamond Season Presale that's going to be live on Oct 21, Thursday 5pm BST.</p>

    <p>Meantime make sure to load your wallet and stay alert to get your spot secured for round one with the exclusive price of $0.07.</p>

    <p>Don't forget to share your affiliate link for you to earn 10% bonus on incoming purchases under your affiliation. Link can be copied from your wallet menu.</p>

    <p>Looking forward to have you as a Holder!</p>

    <p>SlamChat Team!</p>
    <br/>
    <h4>{{$details['emailSubject']}}</h4>
    <p>{{$details['emailContent']}}</p>
</body>

</html>
