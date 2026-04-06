{{-- @extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable')) --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Maintenance Page | OCP System Upgrade</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #f5f7fc 0%, #eef2f8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        position: relative;
        overflow: hidden;
    }

    /* SVG Waves */
    .wave-left, .wave-right {
        position: fixed;
        top: 0;
        width: 350px;
        height: 100vh;
        z-index: 0;
        pointer-events: none;
    }
    .wave-left {
        left: 0;
        transform: scaleX(-1);
    }
    .wave-right {
        right: 0;
    }

    .container {
        max-width: 900px;
        width: 100%;
        overflow: hidden;
        padding: 40px 30px 50px;
        background: rgba(255,255,255,0.95);
        border-radius: 32px;
        box-shadow: 0 8px 32px rgba(11,62,168,0.08);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    h1 {
        color: #e1251b;
        font-size: clamp(2rem, 8vw, 3rem);
        font-weight: 800;
        line-height: 1.2;
    }

    h1 span {
        display: block;
    }

    .subtitle {
        margin-top: 20px;
        color: #0b3ea8;
        font-size: clamp(1rem, 4vw, 1.2rem);
        font-weight: 600;
        line-height: 1.4;
        padding: 0 10px;
        text-align: center;
    }

    .text {
        margin-top: 20px;
        color: #0b3ea8;
        font-size: clamp(0.9rem, 3.5vw, 1rem);
        line-height: 1.6;
        padding: 0 5px;
        text-align: center;
    }

    .highlight {
        font-weight: 700;
        background: #fee2e1;
        padding: 2px 10px;
        border-radius: 20px;
        display: inline-block;
        white-space: nowrap;
    }

    .thankyou {
        margin-top: 25px;
        color: #0b3ea8;
        font-weight: 500;
        font-size: clamp(0.9rem, 3.5vw, 1rem);
    }

    .image {
        margin-top: 0;
        padding: 0 10px;
        position: relative;
        z-index: 1;
        /* transform: translateY(-80px); */
        /* transition: transform 0.3s ease; */
    }

    .image img {
        max-width: 100%;
        height: auto;
        width: 100%;
        display: block;
        margin: 0 auto;
    }

    /* Mobile Specific Styles */
    @media (max-width: 768px) {
        body {
        padding: 15px;
        align-items: flex-start;
        padding-top: 40px;
        }
        .wave-left, .wave-right {
        width: 180px;
        }
        .container {
        padding: 25px 10px 35px;
        border-radius: 28px;
        }
        .subtitle {
        margin-top: 15px;
        }
        .text {
        margin-top: 18px;
        }
        .highlight {
        white-space: normal;
        display: inline-block;
        padding: 3px 12px;
        }
        .image {
        /* transform: translateY(-50px); */
        padding: 0;
        }
        .thankyou {
        margin-top: 20px;
        }
    }

    @media (max-width: 480px) {
        .wave-left, .wave-right {
        width: 100px;
        }
        .container {
        padding: 15px 2px 20px;
        border-radius: 20px;
        }
        .subtitle {
        margin-top: 12px;
        }
        .text {
        margin-top: 15px;
        }
        .highlight {
        font-size: 0.85rem;
        padding: 2px 8px;
        }
        .image {
        /* transform: translateY(-40px); */
        }
        .thankyou {
        margin-top: 18px;
        }
    }

    @media (max-width: 768px) and (orientation: landscape) {
        body {
        padding: 20px;
        }
        .container {
        padding: 20px 10px 30px;
        }
        .image img {
        max-height: 50vh;
        width: auto;
        }
        .image {
        /* transform: translateY(-30px); */
        }
    }

    @media (hover: none) and (pointer: coarse) {
        .highlight {
        cursor: default;
        }
    }
    </style>
</head>
<body>
    <!-- Left Red Wave -->
    <div class="wave-left" aria-hidden="true">
        <svg width="100%" height="100%" viewBox="0 0 350 1080" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="transform: scaleX(-1);">
            <path d="M0,0 Q80,200 0,400 Q-60,600 80,800 Q200,1000 0,1080 L0,1080 L0,0 Z" fill="#e1251b" fill-opacity="0.18"/>
        </svg>
    </div>
    <!-- Right Blue Wave -->
    <div class="wave-right" aria-hidden="true">
        <svg width="100%" height="100%" viewBox="0 0 350 1080" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M350,0 Q270,200 350,400 Q410,600 270,800 Q150,1000 350,1080 L350,1080 L350,0 Z" fill="#0b3ea8" fill-opacity="0.18"/>
        </svg>
    </div>
    <div class="container">
        <h1>
            <span>CLIENT ADVISORY</span>
        </h1>
        <div class="subtitle">
            Please be informed that the Online Compliance Portal (OCP) is currently undergoing a system upgrade to improve performance and better serve you.
        </div>
        <div class="text">
            During this time, the OCP is temporarily unavailable from
            <span class="highlight">April 2 to 5, 2026.</span>
            {{-- We recommend completing any urgent transactions ahead of the scheduled downtime. --}}
        </div>
        <div class="thankyou">
            Thank you for your understanding.
        </div>
        {{-- <div style="height: 1rem;"></div>
        <div class="image">
            <img src="{{ asset('maintenance/maintenance.png-removebg-preview.png') }}" alt="System Maintenance">
        </div> --}}
    </div>
</body>
</html>
