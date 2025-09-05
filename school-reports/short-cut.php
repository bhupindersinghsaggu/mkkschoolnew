<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MK K School - Add to Home Screen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .container {
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            margin: 20px 0;
        }
        
        header {
            background: #4a6fc4;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .logo {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #4a6fc4;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .instructions-container {
            display: flex;
            flex-wrap: wrap;
        }
        
        .device-section {
            flex: 1;
            min-width: 300px;
            padding: 30px;
        }
        
        .mobile-section {
            background: #f9f9f9;
            border-right: 1px solid #eee;
        }
        
        .desktop-section {
            background: #f0f4ff;
        }
        
        h2 {
            color: #4a6fc4;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4a6fc4;
            display: flex;
            align-items: center;
        }
        
        h2 i {
            margin-right: 10px;
        }
        
        .step {
            display: flex;
            margin-bottom: 25px;
            align-items: flex-start;
        }
        
        .step-number {
            background: #4a6fc4;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            font-weight: bold;
        }
        
        .step-content {
            flex: 1;
        }
        
        .step-content h3 {
            margin-bottom: 5px;
            color: #4a6fc4;
        }
        
        .screenshot {
            width: 100%;
            border-radius: 10px;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }
        
        .browser-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .browser-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 70px;
        }
        
        .browser-icon i {
            font-size: 2rem;
            color: #4a6fc4;
            margin-bottom: 5px;
        }
        
        .browser-icon span {
            font-size: 0.8rem;
            text-align: center;
        }
        
        .cta-button {
            display: block;
            width: 100%;
            padding: 15px;
            background: #4a6fc4;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 20px;
            transition: background 0.3s;
        }
        
        .cta-button:hover {
            background: #3a5ba8;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            color: white;
            margin-top: auto;
        }
        
        @media (max-width: 768px) {
            .instructions-container {
                flex-direction: column;
            }
            
            .mobile-section {
                border-right: none;
                border-bottom: 1px solid #eee;
            }
            
            header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <i class="fas fa-school"></i>
            </div>
            <h1>MK K School Dashboard</h1>
            <p>Add shortcut to your home screen or desktop for quick access</p>
        </header>
        
        <div class="instructions-container">
            <div class="device-section mobile-section">
                <h2><i class="fas fa-mobile-alt"></i> Mobile Devices</h2>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Open in Browser</h3>
                        <p>Open the website in Safari (iOS) or Chrome (Android).</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Tap Share Button</h3>
                        <p>Tap the share icon at the bottom (iOS) or top right (Android).</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Add to Home Screen</h3>
                        <p>Scroll down and select "Add to Home Screen" option.</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Confirm and Enjoy</h3>
                        <p>Name your shortcut and tap "Add". The icon will appear on your home screen.</p>
                    </div>
                </div>
                
                <a href="https://mkkschool.com/school-reports/super_admin/dashboard.php" class="cta-button">
                    <i class="fas fa-external-link-alt"></i> Go to Dashboard
                </a>
            </div>
            
            <div class="device-section desktop-section">
                <h2><i class="fas fa-desktop"></i> Desktop Computers</h2>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Open in Browser</h3>
                        <p>Navigate to the MK K School dashboard in your preferred browser.</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Browser Instructions</h3>
                        <p>Depending on your browser, follow these steps:</p>
                        
                        <div class="browser-icons">
                            <div class="browser-icon">
                                <i class="fab fa-chrome"></i>
                                <span>Chrome: Menu → More Tools → Create Shortcut</span>
                            </div>
                            <div class="browser-icon">
                                <i class="fab fa-edge"></i>
                                <span>Edge: Menu → More Tools → Pin to Taskbar</span>
                            </div>
                            <div class="browser-icon">
                                <i class="fab fa-firefox"></i>
                                <span>Firefox: Menu → More Tools → Pin to Taskbar</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Create Shortcut</h3>
                        <p>Follow your browser's prompts to create a desktop or taskbar shortcut.</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Quick Access</h3>
                        <p>Use your new shortcut for quick access to the dashboard.</p>
                    </div>
                </div>
                
                <a href="https://mkkschool.com/school-reports/super_admin/dashboard.php" class="cta-button">
                    <i class="fas fa-external-link-alt"></i> Go to Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <footer>
        <p>MK K School &copy; 2023. Providing quality education management tools.</p>
    </footer>

    <script>
        // Simple animation for step elements
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.step');
            
            steps.forEach((step, index) => {
                // Add delay for appearance
                step.style.opacity = '0';
                step.style.transition = 'opacity 0.5s ease';
                
                setTimeout(() => {
                    step.style.opacity = '1';
                }, 100 * index);
            });
            
            // Add click event for the buttons
            const buttons = document.querySelectorAll('.cta-button');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Redirecting to MK K School Dashboard. After the page loads, use your browser\'s menu to create a shortcut.');
                    window.location.href = this.href;
                });
            });
        });
    </script>
</body>
</html>