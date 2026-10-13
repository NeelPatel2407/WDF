
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - CampusCore</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <header>
        <h1>CampusCore</h1>
        <p>CHARUSAT Student Registration</p>
    </header>

    <main>

        <h2>Create Student Account</h2>

        <nav>
            <a href="http://127.0.0.1:5500/PRACTICAL-2/Home.html">Home</a>
            <a href="http://localhost/WDF/PRACTICAL-10/login.php">Login</a>
            <a href="http://127.0.0.1:5500/PRACTICAL-2/Contactsupport%26FAQ.html">Help & FAQ</a>
        </nav>

        <br>

        <form id="registrationForm" action="process.php" method="POST" novalidate>

            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName"
                       placeholder="Enter first name" required>
                <span class="error" id="firstNameError"></span>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName"
                       placeholder="Enter last name" required>
                <span class="error" id="lastNameError"></span>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                       minlength="3" maxlength="50"
                       pattern="[A-Za-z0-9_]{3,50}"
                       placeholder="Choose a username" required>
                <span class="error" id="usernameError"></span>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                       placeholder="Enter email address" required>
                <span class="error" id="emailError"></span>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile"
                       maxlength="10" minlength="10"
                       pattern="[0-9]{10}"
                       placeholder="Enter 10-digit mobile number" required>
                <span class="error" id="mobileError"></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       minlength="8" maxlength="16"
                       placeholder="Create a strong password"
                       autocomplete="new-password" required>

                <div class="strength-box">
                    <div id="strengthBar"></div>
                </div>

                <span id="strengthText"></span>

                <span class="error" id="passwordError"></span>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword"
                       name="confirmPassword"
                       placeholder="Re-enter your password"
                       autocomplete="new-password" required>
                <span class="error" id="confirmPasswordError"></span>
            </div>

            <div class="form-group">
                <label for="course">Course</label>
                <select id="course" name="course" required>
                    <option value="">Select Course</option>
                    <option value="B.Tech CSE">B.Tech CSE</option>
                    <option value="B.Tech IT">B.Tech IT</option>
                    <option value="B.Tech CE">B.Tech CE</option>
                </select>
                <span class="error" id="courseError"></span>
            </div>

            <div class="form-group">
                <label for="year">Year</label>
                <select id="year" name="year" required>
                    <option value="">Select Year</option>
                    <option value="First Year">First Year</option>
                    <option value="Second Year">Second Year</option>
                    <option value="Third Year">Third Year</option>
                    <option value="Fourth Year">Fourth Year</option>
                </select>
                <span class="error" id="yearError"></span>
            </div>

            <fieldset>
                <legend>Gender</legend>

                <label class="radio-label">
                    <input type="radio" name="gender" value="Male" required>
                    Male
                </label>

                <label class="radio-label">
                    <input type="radio" name="gender" value="Female">
                    Female
                </label>

                <label class="radio-label">
                    <input type="radio" name="gender" value="Other">
                    Other
                </label>

                <span class="error" id="genderError"></span>
            </fieldset>

            <div class="terms">
                <label>
                    <input type="checkbox" id="terms" name="terms"
                           value="yes" required>
                    I accept the Terms and Conditions
                </label>
                <span class="error" id="termsError"></span>
            </div>

            <div class="buttons">
                <button type="submit">Register</button>
                <button type="reset">Reset</button>
            </div>

            <p id="successMessage"></p>

        </form>

    </main>

    <footer>
        © 2026 Charotar University of Science & Technology. All Rights Reserved
    </footer>

</div>

<script src="registration.js"></script>
</body>
</html>
