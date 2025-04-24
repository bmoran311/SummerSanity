<section id="cta">
    <div class="container">
        <h2>Get started now for free!</h2>
        <div class="card register-card">
            <div class="gradient"></div>
            <div class="header">
                <img src="/assets/icons/register.svg" alt="Register Icon" />
                <h4>Create an Account</h4>
                <p>Send an invite to friends and family to share schedules and plan activities.</p>
            </div>
            <form id="loginForm" class="register__form" method="POST" action="/guardian/register">                
                @csrf
                <div class="name">
                    <div class="input__field">
                        <img src="/assets/icons/profile.svg" alt="Profile icon" />
                        <input type="text" placeholder="First Name" name="firstName" class="input__first" />
                    </div>
                    <div class="input__field">
                        <img src="/assets/icons/profile.svg" alt="Profile icon" />
                        <input type="text" placeholder="Last Name" name="lastName" class="input__last" />
                    </div>
                </div>
                <div class="input__field">
                    <img src="/assets/icons/email.svg" alt="Email icon" />
                    <input type="email" placeholder="Email" name="email" class="input__email" />
                </div>
                <div class="input__field">
                    <img src="/assets/icons/password.svg" alt="Password icon" />
                    <input type="password" placeholder="Password" name="password" class="input__first" />
                </div>
                <div class="input__field">
                    <img src="/assets/icons/password.svg" alt="Confirm Password icon" />
                    <input type="password" placeholder="Confirm Password" name="confirmed_password" class="input__first" />
                </div>
                <div class="input__field">  
                    <img src="/assets/icons/vacation.svg" alt="Zip Code" />                                                          
                    <input type="text" placeholder="Zip Code" name="zip_code" maxlength="50" class="input__zip">
                </div>
                <div class="input__field">  
                    <img src="/assets/icons/profile.svg" alt="Phone" />                                                          
                    <input type="text" placeholder="Phone" name="phone" maxlength="50" class="input__phone">
                </div>
                <div class="input__field">
                    <p class="submission-text">Preferred Communication Method:</p><br />
                    <label><input type="radio" name="communication_preference" value="email" /> Email</label>
                    &nbsp;&nbsp;
                    <label><input type="radio" name="communication_preference" value="text" /> Text</label>
                </div>
                <p class="submission-text">By Submitting, you are agreeing to the terms of services and privacy policy.</p>
            </form>

            <button class="btn btn--sm">Get Started</button>
        </div>
    </div>

    <br><br>
    <div class="container">
        <section id="login">
            <h2>Please login and start planning</h2>
            <div class="card register-card">
                <div class="gradient"></div>
                <div class="header">
                    <img src="/assets/icons/register.svg" alt="Register Icon" />
                    <h4>Login</h4>               
                </div>               

                @if ($errors->any())
                    <div class="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <form id="loginForm" class="login__form" method="POST" action="/guardian/login">                
                    @csrf
                    <div class="input__field">
                        <img src="/assets/icons/email.svg" alt="Profile icon" />
                        <input type="email" placeholder="Email" name="email" class="input__email" />
                    </div>
                    <div class="input__field">
                        <img src="/assets/icons/password.svg" alt="Profile icon" />
                        <input type="password" placeholder="Password" name="password" class="input__first" />
                    </div>                                                

                    <button type="submit" class="btn btn--sm">Login</button>
                </form>
            </div>
        </div>
    </div>
</section>    