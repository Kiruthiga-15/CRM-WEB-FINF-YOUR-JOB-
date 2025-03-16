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
                            '50%': { transform: 'scale(1.1)' },
                            '100%': { transform: 'scale(1)' }
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="relative h-screen w-full bg-cover bg-center font-sans" 
    style="background-image: url('{{ asset('build/assets/img/bgimg1.jpg') }}');">

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black opacity-40"></div>

    <!-- Hero Content -->
    <section class="relative flex flex-col items-center justify-center h-screen text-white text-center px-6">
        
        <!-- Animated Heading -->
        <h1 class="text-6xl font-extrabold drop-shadow-lg animate-colorCycle animate-textPulse">
            Find Your Dream Job
        </h1>

        <p class="mt-4 text-xl font-light text-gray-300 drop-shadow-md">
            Join thousands of verified professionals & employers.
        </p>

        <div class="mt-8 space-x-4">
            <a href="{{ route('user.register') }}" 
                class="bg-primary text-black font-semibold px-8 py-4 rounded-full shadow-lg text-lg hover:bg-yellow-500 transition duration-300">
                Register as User
            </a>

            <a href="{{ route('admin.login') }}" 
                class="bg-secondary text-white font-semibold px-8 py-4 rounded-full shadow-lg text-lg hover:bg-blue-700 transition duration-300">
                Admin Login
            </a>
        </div>
    </section>

</body>
</html>
