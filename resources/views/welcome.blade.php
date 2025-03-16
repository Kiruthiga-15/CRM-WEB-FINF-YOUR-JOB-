<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Verified Profiles</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#ffcc00', // Yellow
                        secondary: '#007bff', // Blue
                        danger: '#ff3b3b', // Red
                    },
                    animation: {
                        colorCycle: 'colorCycle 4s infinite alternate',
                        textPulse: 'textPulse 4s infinite alternate',
                    },
                    keyframes: {
                        colorCycle: {
                            '0%': { color: '#ff3b3b' },  /* Red */
                            '50%': { color: '#007bff' }, /* Blue */
                            '100%': { color: '#ffcc00' } /* Yellow */
                        },
                        textPulse: {
                            '0%': { transform: 'scale(1)' },
                            '50%': { transform: 'scale(1.05)' },
                            '100%': { transform: 'scale(1)' }
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="relative h-screen w-full bg-cover bg-center font-sans flex items-center justify-center px-4" 
    style="background-image: url('{{ asset('build/assets/img/bgimg1.jpg') }}');">

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <!-- Hero Content -->
    <section class="relative z-10 flex flex-col items-center text-white text-center w-full max-w-4xl">
        
        <!-- Animated Heading -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold drop-shadow-lg animate-colorCycle animate-textPulse">
            Find Your Dream Job
        </h1>

        <p class="mt-4 text-base sm:text-lg md:text-xl font-light text-gray-300 drop-shadow-md max-w-2xl">
            Join thousands of verified professionals & employers.
        </p>

        <div class="mt-8 w-full flex flex-col sm:flex-row items-center justify-center gap-6"> 
            <a href="{{ route('user.register') }}" 
                class="w-full sm:w-auto bg-primary text-black font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-full shadow-lg text-lg hover:bg-yellow-500 transition duration-300 text-center">
                Register as User
            </a>

            <a href="{{ route('admin.login') }}" 
                class="w-full sm:w-auto bg-secondary text-white font-semibold px-6 sm:px-8 py-3 sm:py-4 rounded-full shadow-lg text-lg hover:bg-blue-700 transition duration-300 text-center">
                Admin Login
            </a>
        </div>
    </section>

</body>
</html>
