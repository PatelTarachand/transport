<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap" rel="stylesheet">
    <style>
        body {
            background: green
        }

        svg {
            font-family: 'Russo One', sans-serif;
            position: absolute;
            width: 100%;
            height: 100%;
        }

        svg text {
            text-transform: uppercase;
            animation: stroke 5s infinite alternate;
            stroke-width: 2;
            stroke: #ffffff;
            font-size: 140px;
            font-family: 'Noto Nastaliq Urdu', serif;
        }

        @keyframes stroke {
            0% {
                fill: rgba(72, 138, 20, 0);
                stroke: rgb(255 255 255);
                stroke-dashoffset: 25%;
                stroke-dasharray: 0 50%;
                stroke-width: 2;




                
            }

            70% {
                fill: rgba(72, 138, 20, 0);
                stroke: rgb(255 255 255);
            }

            80% {
                fill: rgba(72, 138, 20, 0);
                stroke: rgb(255 255 255);
                stroke-width: 3;
            }

            100% {
                fill: rgb(255 255 255);
                stroke: rgba(54, 95, 160, 0);
                stroke-dashoffset: -25%;
                stroke-dasharray: 50% 0;
                stroke-width: 0;
            }
        }
    </style>
</head>

<body>


<svg viewBox="0 0 1320 300">
	<text x="50%" y="50%" dy=".35em" text-anchor="middle">
		BIJAK
	</text>
</svg>	
</body>

</html>