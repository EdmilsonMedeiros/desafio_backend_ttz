<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel API</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

            <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }

            .welcome-container {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
            }

            .welcome-text {
                font-size: 5rem;
                font-weight: 900;
                color: white;
                text-align: center;
                letter-spacing: 0.1em;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
                margin: 0;
                line-height: 1.1;
            }

            .letter {
                display: inline-block;
                opacity: 0;
                transform: translateY(50px) scale(0.5);
                animation: letterAppear 0.6s ease-out forwards;
            }

            @keyframes letterAppear {
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            .word {
                display: inline-block;
                margin: 0 0.2em;
            }

            .glow-effect {
                animation: glow 2s ease-in-out infinite alternate;
            }

            @keyframes glow {
                from {
                    text-shadow: 2px 2px 4px rgba(0,0,0,0.3), 0 0 20px rgba(255,255,255,0.3);
                }
                to {
                    text-shadow: 2px 2px 4px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.6), 0 0 40px rgba(255,255,255,0.4);
                }
            }

            .subtitle {
                font-size: 1.5rem;
                color: rgba(255,255,255,0.8);
                text-align: center;
                margin-top: 2rem;
                opacity: 0;
                animation: fadeIn 1s ease-out 3s forwards;
            }

            @keyframes fadeIn {
                to {
                    opacity: 1;
                }
            }

            .floating-particles {
                position: absolute;
                width: 100%;
                height: 100%;
                overflow: hidden;
                top: 0;
                left: 0;
                z-index: -1;
            }

            .particle {
                position: absolute;
                background: rgba(255,255,255,0.1);
                border-radius: 50%;
                animation: float 6s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px) rotate(0deg);
                }
                50% {
                    transform: translateY(-20px) rotate(180deg);
                }
            }

            /* Responsive */
            @media (max-width: 768px) {
                .welcome-text {
                    font-size: 3rem;
                }
                
                .subtitle {
                    font-size: 1.2rem;
                    padding: 0 1rem;
                }
            }

            @media (max-width: 576px) {
                .welcome-text {
                    font-size: 2.5rem;
                }
                
                .subtitle {
                    font-size: 1rem;
                }
            }
            </style>
    </head>
    <body>
        <div class="welcome-container">
            <div class="floating-particles">
                <!-- Partículas serão adicionadas via JavaScript -->
                </div>
            
            <div class="text-center">
                <h1 class="welcome-text" id="welcomeText"></h1>
                <p class="subtitle">Your API is ready to serve amazing applications</p>
                <a href="{{ url('/docs') }}" class="btn btn-primary">API Documentation</a>
                </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const text = "WELCOME TO THE API";
                const words = text.split(' ');
                const welcomeTextElement = document.getElementById('welcomeText');
                
                let letterIndex = 0;
                let currentWordIndex = 0;
                
                // Criar estrutura de palavras
                words.forEach((word, wordIndex) => {
                    const wordSpan = document.createElement('span');
                    wordSpan.className = 'word';
                    
                    // Adicionar letras da palavra
                    for (let i = 0; i < word.length; i++) {
                        const letterSpan = document.createElement('span');
                        letterSpan.className = 'letter';
                        letterSpan.textContent = word[i];
                        wordSpan.appendChild(letterSpan);
                    }
                    
                    welcomeTextElement.appendChild(wordSpan);
                    
                    // Adicionar espaço entre palavras (exceto na última)
                    if (wordIndex < words.length - 1) {
                        const spaceSpan = document.createElement('span');
                        spaceSpan.innerHTML = '&nbsp;';
                        welcomeTextElement.appendChild(spaceSpan);
                    }
                });
                
                // Animar letras
                const letters = document.querySelectorAll('.letter');
                
                function animateNextLetter() {
                    if (letterIndex < letters.length) {
                        letters[letterIndex].style.animationDelay = '0s';
                        letterIndex++;
                        setTimeout(animateNextLetter, 150); // Delay entre letras
                    } else {
                        // Adicionar efeito de brilho após completar
                        setTimeout(() => {
                            welcomeTextElement.classList.add('glow-effect');
                        }, 500);
                    }
                }
                
                // Iniciar animação após um pequeno delay
                setTimeout(animateNextLetter, 500);
                
                // Criar partículas flutuantes
                function createParticles() {
                    const particlesContainer = document.querySelector('.floating-particles');
                    const particleCount = 50;
                    
                    for (let i = 0; i < particleCount; i++) {
                        const particle = document.createElement('div');
                        particle.className = 'particle';
                        
                        // Tamanho aleatório
                        const size = Math.random() * 4 + 2;
                        particle.style.width = size + 'px';
                        particle.style.height = size + 'px';
                        
                        // Posição aleatória
                        particle.style.left = Math.random() * 100 + '%';
                        particle.style.top = Math.random() * 100 + '%';
                        
                        // Delay de animação aleatório
                        particle.style.animationDelay = Math.random() * 6 + 's';
                        particle.style.animationDuration = (Math.random() * 3 + 4) + 's';
                        
                        particlesContainer.appendChild(particle);
                    }
                }
                
                createParticles();
            });
        </script>
    </body>
</html>
