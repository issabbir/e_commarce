<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexora - Super Admin Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Background Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: float 10s infinite ease-in-out alternate;
            z-index: 0;
        }
        .orb-1 { width: 400px; height: 400px; background: #3b82f6; top: -100px; left: -100px; }
        .orb-2 { width: 300px; height: 300px; background: #8b5cf6; bottom: -50px; right: -50px; animation-delay: -5s; }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, 30px) scale(1.1); }
        }

        /* Glass Card */
        .login-card {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 50px 40px;
            width: 100%;
            max-width: 420px;
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: #fff;
            position: relative;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.8s forwards ease-out;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
        }

        @keyframes slideUp {
            to { transform: translateY(0); opacity: 1; }
        }

        .brand-logo {
            font-size: 34px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 5px;
            background: linear-gradient(to right, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }
        
        .sub-text {
            color: #94a3b8;
            text-align: center;
            font-size: 15px;
            margin-bottom: 40px;
            font-weight: 300;
        }

        /* Form Inputs */
        .form-control {
            background: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            padding: 14px 15px;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        .form-control::placeholder {
            color: #475569;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2) !important;
            border-color: #3b82f6 !important;
            background: rgba(0, 0, 0, 0.4) !important;
        }
        
        .form-label {
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }

        /* Button */
        .btn-login {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            border: none;
            color: white;
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.6);
            color: white;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border-left: 4px solid #ef4444;
            color: #fca5a5;
            padding: 12px 15px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

    <!-- Backdrops -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- Login Area -->
    <div class="login-card">
        <div class="brand-logo">NEXORA</div>
        <div class="sub-text">Super Admin Portal Access</div>

        @if($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('superadmin.login') }}">
            @csrf
            <div class="mb-4">
                <label class="form-label">Administrator Email</label>
                <input type="email" name="email" class="form-control" placeholder="director@nexora.com" required autofocus>
            </div>
            
            <div class="mb-5">
                <label class="form-label">Security Protocol (Password)</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn-login">
                Authenticate Securely
            </button>
        </form>
    </div>

</body>
</html>
