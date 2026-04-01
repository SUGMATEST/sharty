// Execute JS required for special effects on certain themes
                    const solunarNightEffects = () => {
                        const body = document.body;
                        const staticElements = ['moon', 'stars'];
                        
                        const effectContainer = document.createElement('div');
                        effectContainer.id = "dynamic-theme-effect-container";
                        body.appendChild(effectContainer);

                        staticElements.forEach(className => {
                            if (!document.querySelector(`.${className}`)) {
                                const div = document.createElement('div');
                                div.className = className;
                                effectContainer.appendChild(div);
                            }
                        });

                        const starsContainer = document.querySelector('.stars');

                        function createTwinklingStars(count = 150) {
                            for (let i = 0; i < count; i++) {
                                const star = document.createElement('div');
                                star.className = 'twinkling-star';
                                star.style.top = `${Math.random() * 100}%`;
                                star.style.left = `${Math.random() * 100}%`;
                                star.style.width = `${Math.random() * 1.5 + 0.5}px`;
                                star.style.height = star.style.width;
                                star.style.animationDelay = `${Math.random() * 5}s`;
                                star.style.animationDuration = `${Math.random() * 3 + 2}s`;
                                starsContainer.appendChild(star);
                            }
                        }

                        createTwinklingStars();

                        
                        function createShootingStar() {
                            const div = document.createElement('div');
                            div.className = 'shooting-star';
                            const top = Math.random() * 5 + '%';
                            const left = Math.random() * 100 + '%';
                            div.style.top = top;
                            div.style.left = left;
                            body.appendChild(div);
                            setTimeout(() => {
                                if (div.parentNode) {
                                    div.remove();
                                }
                            }, 5000);
                        }

                        setInterval(() => {
                            createShootingStar();
                        }, Math.random() * 3000 + 2000);

                        function updateMoon() {
                            const moon = document.querySelector('.moon');
                            if (moon) {
                                const hour = new Date().getHours() + new Date().getMinutes() / 60;
                                if (hour >= 18 || hour < 6) {
                                    moon.style.display = 'block';
                                    const p = hour >= 18 ? (hour - 18) / 12 : (hour + 6) / 12;
                                    moon.style.left = (-15 + p * 130) + '%';
                                    moon.style.top = (100 - Math.sin(p * Math.PI) * 80) + '%';
                                } else {
                                    moon.style.display = 'none';
                                }
                            }
                        }

                        updateMoon();
                        setInterval(updateMoon, 60000);
                    };

                    const solunarDayEffects = () => {
                        const effectContainer = document.createElement('div');
                        effectContainer.id = "dynamic-theme-effect-container";
                        document.body.appendChild(effectContainer);

                        // Function to calculate sun's position in a continuous half-circle based on local time
                        function updateSunPosition() {
                            const now = new Date();
                            
                            // Calculate time as a fraction of a 24-hour day
                            const timeFraction = (now.getHours() + now.getMinutes() / 60 + now.getSeconds() / 3600) / 24;
                            
                            // Map time to a 12-hour day cycle (6 AM to 6 PM for sunrise to sunset)
                            const dayFraction = (timeFraction - 0.25) * 2; // Shift to start at 6 AM
                            const normalizedFraction = Math.max(0, Math.min(1, dayFraction)); // Clamp 0 to 1
                            
                            // Calculate semi-circle position
                            const leftPos = normalizedFraction * 100; // 0% to 100% across screen
                            const angle = normalizedFraction * Math.PI; // 0 to π radians for half-circle
                            const topPos = 60 - 50 * Math.sin(angle); // 60% at sunrise/sunset, 10% at noon
                            
                            // Update body::before styles
                            document.body.style.setProperty('--sun-left', `${leftPos}%`);
                            document.body.style.setProperty('--sun-top', `${topPos}%`);
                        }

                        // Function to create and animate clouds
                        function setupClouds() {
                            const cloudCount = 6; // Six cloud clusters
                            const clouds = [];
                            
                            // Create cloud elements
                            for (let i = 1; i <= cloudCount; i++) {
                                const cloud = document.createElement('div');
                                cloud.className = `cloud cloud${i}`;
                                // Add four sub-divs for cluster effect
                                for (let j = 1; j <= 4; j++) {
                                    const cloudPart = document.createElement('div');
                                    cloud.appendChild(cloudPart);
                                }
                                document.getElementById("dynamic-theme-effect-container").appendChild(cloud);
                                
                                // Initialize cloud properties
                                clouds.push({
                                    element: cloud,
                                    left: Math.random() * 100, // Random initial left position (0% to 100%)
                                    top: Math.random() * 70, // Random top position (0% to 70%)
                                    speed: 0.04 + Math.random() * 0.04 // Slower speed (0.04% to 0.08% per second)
                                });
                            }
                            
                            // Update cloud positions using requestAnimationFrame
                            let lastTime = performance.now();
                            function updateClouds(timestamp) {
                                const deltaTime = (timestamp - lastTime) / 1000; // Time in seconds
                                clouds.forEach(cloud => {
                                    cloud.left += cloud.speed * deltaTime * 100; // Move right
                                    if (cloud.left > 100) {
                                        // Reset to off-screen left with new random top position
                                        cloud.left = -20; // Start just off-screen
                                        cloud.top = Math.random() * 70; // New top in top 70%
                                    }
                                    cloud.element.style.left = `${cloud.left}%`;
                                    cloud.element.style.top = `${cloud.top}%`;
                                });
                                lastTime = timestamp;
                                requestAnimationFrame(updateClouds);
                            }
                            
                            // Initial cloud position
                            requestAnimationFrame(updateClouds);
                        }

                        // Function to create wave layers
                        function setupWaves() {
                            const waveCount = 5; // Five wave layers
                            for (let i = 1; i <= waveCount; i++) {
                                const wave = document.createElement('div');
                                wave.className = `wave wave${i}`;
                                wave.style.top = `${85 + (i - 1) * 1.25}%`; // Stack waves in bottom 15%
                                const waveLayer = document.createElement('div');
                                wave.appendChild(waveLayer);
                                document.getElementById("dynamic-theme-effect-container").appendChild(wave);
                            }
                        }

                        // Apply styles for sun, clouds, waves, and initial load
                        const styleSheet = document.createElement('style');
                        styleSheet.textContent = `
                            body::before {
                                left: var(--sun-left, 0%);
                                top: var(--sun-top, 60%);
                            }
                            body.initial-load::before, body.initial-load .cloud, body.initial-load .wave {
                                transition: none !important;
                            }
                        `;
                        document.head.appendChild(styleSheet);

                        // Set initial sun, cloud, and wave positions without transition
                        document.body.classList.add('initial-load');
                        updateSunPosition();
                        setupClouds();
                        setupWaves();

                        // Enable transitions after initial load
                        setTimeout(() => {
                            document.body.classList.remove('initial-load');
                        }, 0);

                        // Update sun every 60 seconds
                        setInterval(updateSunPosition, 60000);
                    }

$(function() {
    const stylesheet = localStorage.stylesheet ? localStorage.stylesheet : document.body.dataset.stylesheet;

    switch (stylesheet) {
        case 'Frooty':
            document.body.insertAdjacentHTML('beforeend',
                `<div class="snowflakes">
                <img class="snowflake" src="/static/froot/froot1.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot2.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot3.png" style="width:70px;">
                <img class="snowflake" src="/static/froot/froot4.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot5.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot6.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot7.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot8.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot9.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot10.png" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot11.gif" style="width:50px;">
                <img class="snowflake" src="/static/froot/froot12.png" style="width:50px;">
                </div>`
            );

            break;

	case 'America':
	case 'america.css':
		document.body.insertAdjacentHTML('beforeend',
			`<!-- Bouncing Burger Container -->
			<div class="bounce-container">
			  <div class="x">
			    <img class="y" src="/static/america/burger.gif" alt="burger" />
			  </div>
			</div>`
		);

		document.addEventListener('click', function(event) {
		  // Create the firework element
		  let firework = document.createElement('div');
		  firework.classList.add('firework');
		  
		  // Position the firework at the click location
		  firework.style.left = `${event.clientX}px`;
		  firework.style.top = `${event.clientY}px`;

		  // Append the firework to the body
		  document.body.appendChild(firework);

		  // Remove the firework after animation ends (2 seconds)
		  setTimeout(function() {
		    firework.remove();
		  }, 2000); // Matches the duration of the animation
		});

		break;
        
        case 'Ocean':
            const soislug = document.createElement("img");
            soislug.setAttribute('src', '/static/ocean/slug.png');
            soislug.setAttribute('class', 'soislug');

            const soifish = document.createElement("img");
            soifish.setAttribute('src', '/static/ocean/fish.png');
            soifish.setAttribute('class', 'soifish');

            document.body.append(soislug, soifish);

            break;

	case 'Solunar - Night':
	case 'solunar/night.css':
		solunarNightEffects();
		break;
	case 'Solunar - Day':
		solunarDayEffects();
		break

	case 'Solunar':
	case 'solunar.css':
                (() => {
                    const applyTheme = (name) => {
                        const currentTheme = document.getElementById("dynamic-theme-stylesheet");
                        if (currentTheme) {
                            currentTheme.remove();
                        }
                        const currentEffects = document.getElementById("dynamic-theme-effect-container");
                        if (currentEffects) {
                            currentEffects.remove();
                        }
                        document.head.insertAdjacentHTML('beforeend',
	                        `<link id="dynamic-theme-stylesheet" rel="stylesheet" href="/stylesheets/solunar/${name}.css?v2">`
	                    );
	                    
	                    if (name == "night" || name == "dawn") {
	                        solunarNightEffects();
	                    } else {
	                        solunarDayEffects();
	                    }
                    };

                    const themeFromHour = (currentHour) => {
                        if (currentHour >= 6 && currentHour <= 18) {
                            applyTheme("day");
                        } else if (currentHour >= 19 && currentHour <= 20) {
                            applyTheme("evening");
                        } else if (currentHour == 5) {
                            applyTheme("dawn");
                        } else {
                            applyTheme("night");
                        }
                    }

                    themeFromHour((new Date()).getHours());
                    setInterval(themeFromHour((new Date()).getHours()), 1000*60*15);
                })();

		break;
    }
});
