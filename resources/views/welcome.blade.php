<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- "Overpass" Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
        <!-- CSS Stylesheet -->
        <link rel="stylesheet" href="style.css" />
        <title>My Web App</title>
    </head>
    <body>
        <header>
            <nav class="nav">
                <div class="container">
                    <ul class="nav__links">
                        <li class="nav__link"><a href="#hero">Home</a></li>
                        <li class="nav__link"><a href="#calendar">Features</a></li>
                        <li class="nav__link"><a href="#about">About Us</a></li>
                        <li class="nav__link"><a href="#team">Team</a></li>
                    </ul>
                    <div class="logo">
                        <a href="/"><img src="assets/logo.svg" alt="Summer Sanity Logo" /></a>
                    </div>
                    <div class="actions">
                        <button class="btn btn--tertiary btn--sm">Login</button>
                        <button class="btn btn--secondary btn--sm">Register</button>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <section id="hero">
                <img src="assets/masthead.png" alt="Children playing sport" class="hero__image" />
                <div class="overlay"></div>

                <div class="container hero-container">
                    <div class="hero__content">
                        <h1>Simplify Summer Planning</h1>
                        <p>Easily organize camps, sitters, and plans with our user-friendly calendar - AND stay in sync with your trusted circle.</p>

                        <button class="btn">Join Now - It’s Free !</button>
                    </div>

                    <div class="usp">
                        <div class="card usp__item">
                            <h4>All in one place</h4>
                            <p>No more spreadsheets or post-it notes</p>
                        </div>
                        <div class="card usp__item">
                            <h4>Get Inspired</h4>
                            <p>Find new ideas for summer camps and activities</p>
                        </div>
                        <div class="card usp__item">
                            <h4>Coordinate and Share</h4>
                            <p>Cut down on texts, emails and group chats</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="calendar">
                <div class="container">
                    <div class="section-header">
                        <span class="gradient-text">Calendar</span>
                        <h2>Your Summer at a glance</h2>
                    </div>

                    <div class="gradient-bg"></div>

                    <p class="calendar__desc">
                        With our easy to read color-coded calendar, you can switch between viewing your full summer or focus on weekly plans. Adjust camp times, note babysitters,
                        and see your friends’ plans.
                    </p>

                    <img class="calendar__mockup" src="assets/calendar.png" alt="Summer Calendar View Mockup" />

                    <div class="features">
                        <div class="card card__feature">
                            <img src="assets/icons/shield.svg" />
                            <h4>Private & Secure</h4>
                            <p>Your family’s schedule stays safe and accessible only to those you connect with in your calendar.</p>
                        </div>
                        <div class="card card__feature">
                            <img src="assets/icons/calendar.svg" />
                            <h4>Smart Calendar</h4>
                            <p>View all summer plans in one place with a customizable, color-coded layout.</p>
                        </div>
                        <div class="card card__feature">
                            <img src="assets/icons/invitation.svg" />
                            <h4>Easy Invitation</h4>
                            <p>Invite friends via email or text to sync schedules effortlessly.</p>
                        </div>
                        <div class="card card__feature">
                            <img src="assets/icons/share.svg" />
                            <h4>Shared Planning</h4>
                            <p>Coordinate with other caregivers to get inspiration - and maybe even get a carpool going!</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="about">
                <div class="container">
                    <div class="about__image">
                        <img src="assets/about.jpg" alt="Family image" />
                        <div class="card about__content">
                            <h2>About Us</h2>
                            <p>
                                We met in daycare, bonded by inconsistent sleep but consistent childcare schedules. But once our kids hit elementary school, summer turned into a
                                chaotic, week-by-week puzzle. We ditched the clunky spreadsheets and built Summer Sanity to bring back the ease (and fun) of planning with friends.
                            </p>
                            <div class="mission">
                                <img src="assets/icons/mission.svg" />
                                <div class="mission__text">
                                    <h4>Our Mission</h4>
                                    <p>
                                        Simplify summer planning for parents with a user-friendly calendar that makes it easy to coordinate with their trusted circles—because
                                        summer is for fun not frustration.
                                    </p>
                                </div>
                            </div>
                            <button class="btn btn--sm">Get Started</button>
                        </div>
                    </div>
                </div>
            </section>

            <section id="team">
                <div class="container">
                    <div class="section-header">
                        <span class="gradient-text">Our Team</span>
                        <h2>
                            Meet the minds behind <br />
                            summer sanity
                        </h2>
                    </div>

                    <div class="employees-container">
                        <div class="person">
                            <div class="person__portrait">
                                <img src="assets/megan-p-portrait.png" alt="Megan Petrik Portrait Image" />
                                <div class="card social-links">
                                    <a href="https://www.facebook.com" target="_blank">
                                        <img src="assets/icons/facebook-color.svg" alt="Facebook Icon and Link" />
                                    </a>
                                    <a href="https://www.linkedin.com" target="_blank">
                                        <img src="assets/icons/linkedin-color.svg" alt="LinkedIn Icon and Link" />
                                    </a>
                                    <a href="https://www.instagram.com" target="_blank">
                                        <img src="assets/icons/instagram-color.svg" alt="Instagram Icon and Link" />
                                    </a>
                                </div>
                            </div>
                            <div class="person__content">
                                <div class="person__header">
                                    <div class="name__container">
                                        <h4>Megan Petrik</h4>
                                        <p>Mother of two</p>
                                    </div>
                                    <span class="gradient-text">Co-founder</span>
                                </div>
                                <p class="description">
                                    With 20 years in marketing and communications, I’ve always loved building strong messages and meaningful connections. I’m also a mom and when my
                                    kids moved on from the consistency of daycare to the chaos of elementary school summers, I was totally overwhelmed. I found myself losing sleep
                                    over camp registration dates, costs, pickup times, and whether my kids would see their friends. I built complicated spreadsheets and sent them
                                    back and forth with friends, but it never felt like enough. I dreamed of one secure place where parents could plan together easily. With Summer
                                    Sanity, that dream is finally here and this summer I’ll be spending less time in spreadsheets and more time camping with my family, enjoying the
                                    beach, and catching up on my reading.
                                </p>
                            </div>
                        </div>

                        <div class="person person--opposite">
                            <div class="person__portrait">
                                <img src="assets/megan-s-portrait.png" alt="Megan Petrik Portrait Image" />
                                <div class="card social-links">
                                    <a href="https://www.facebook.com" target="_blank">
                                        <img src="assets/icons/facebook-color.svg" alt="Facebook Icon and Link" />
                                    </a>
                                    <a href="https://www.linkedin.com" target="_blank">
                                        <img src="assets/icons/linkedin-color.svg" alt="LinkedIn Icon and Link" />
                                    </a>
                                    <a href="https://www.instagram.com" target="_blank">
                                        <img src="assets/icons/instagram-color.svg" alt="Instagram Icon and Link" />
                                    </a>
                                </div>
                            </div>
                            <div class="person__content">
                                <div class="person__header">
                                    <div class="name__container">
                                        <h4>Megan Spivey</h4>
                                        <p>Mother of two</p>
                                    </div>
                                    <span class="gradient-text">Co-founder</span>
                                </div>
                                <p class="description">
                                    As a leadership coach and founder of Career Outfitters, I’ve built a business rooted in one thing: relationships. Before coaching, I spent two
                                    decades in corporate roles across investment banking, technology, and risk. I’ve seen firsthand how the mental load at home impacts energy and
                                    performance at work. Like so many, I went from daycare structure to summer chaos and quickly saw how lonely and logistical it all became. That’s
                                    why I teamed up with my friend and fellow Megan to create Summer Sanity. This summer, I’m trading the time I used to spend in spreadsheets for
                                    more hikes in Asheville & paddle boarding on Lake Wylie with my co-founder!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <img class="line-separator" src="assets/dotted-separator.svg" alt="Dotted line separator between sections" />

            <section id="cta">
                <div class="container">
                    <h2>Get started now for free!</h2>
                    <div class="card register-card">
                        <div class="gradient"></div>
                        <div class="header">
                            <img src="assets/icons/register.svg" alt="Register Icon" />
                            <h4>Create an Account</h4>
                            <p>Send an invite to friends and family to share schedules and plan activities.</p>
                        </div>
                        <form class="register__form">
                            <div class="name">
                                <div class="input__field">
                                    <img src="assets/icons/profile.svg" alt="Profile icon" />
                                    <input type="text" placeholder="First Name" name="firstName" class="input__first" />
                                </div>
                                <div class="input__field">
                                    <img src="assets/icons/profile.svg" alt="Profile icon" />
                                    <input type="text" placeholder="Last Name" name="lastName" class="input__last" />
                                </div>
                            </div>
                            <div class="input__field">
                                <img src="assets/icons/email.svg" alt="Profile icon" />
                                <input type="email" placeholder="Email" name="email" class="input__email" />
                            </div>
                            <div class="input__field">
                                <img src="assets/icons/password.svg" alt="Profile icon" />
                                <input type="password" placeholder="Password" name="password" class="input__first" />
                            </div>
                            <div class="input__field">
                                <img src="assets/icons/password.svg" alt="Profile icon" />
                                <input type="password" placeholder="Confirm Password" name="confirmPassword" class="input__first" />
                            </div>
                            <p class="submission-text">By Submitting, you are agreeing to the terms of services and privacy policy.</p>
                        </form>

                        <button class="btn btn--sm">Get Started</button>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="gradient-bg"></div>
            <div class="container footer-container">
                <div class="footer__left">
                    <img class="logo" src="assets/logo.svg" alt="Summer Sanity Logo" />
                    <p>&copy; Copyright 2025 Summer Sanity. All rights reserved.</p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com" target="_blank">
                            <img src="assets/icons/facebook-color.svg" alt="Facebook Icon and Link" />
                        </a>
                        <a href="https://www.linkedin.com" target="_blank">
                            <img src="assets/icons/linkedin-color.svg" alt="LinkedIn Icon and Link" />
                        </a>
                        <a href="https://www.instagram.com" target="_blank">
                            <img src="assets/icons/instagram-color.svg" alt="Instagram Icon and Link" />
                        </a>
                    </div>
                </div>
                <div class="footer__right">
                    <div class="links__wrapper">
                        <span class="label">Explore</span>
                        <ul class="links">
                            <li><a href="#hero">Home</a></li>
                            <li><a href="#calendar">Features</a></li>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#team">Team</a></li>
                        </ul>
                    </div>
                    <div class="links__wrapper">
                        <span class="label">Links</span>
                        <ul class="links">
                            <li><a class="disabled" href="#">Privacy Policy</a></li>
                            <li><a class="disabled" href="#">Terms of Services</a></li>
                        </ul>
                    </div>
                    <div class="links__wrapper">
                        <span class="label">Contact</span>
                        <ul class="links">
                            <li><a href="mailto:hello@summersanity.com">hello@summersanity.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
