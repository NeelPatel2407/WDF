<!DOCTYPE html>
<html>
<head>
    <title>CampusCore - Registration</title>
    <link rel="stylesheet" href="registration.css">
</head>

<body>

<div class="page">

    <header>
        <div class="logo">CampusCore</div>
        <p>Student Registration Portal</p>
    </header>

    <main>

        <div class="form-container">

            <h2>Student Registration</h2>
            <p class="subtitle">
                Enter your details to register with CampusCore.
            </p>

            <form action="process.php" method="POST">

                <div class="input-group">
                    <label>Full Name</label>
                    <input
                        type="text"
                        name="name"
                        placeholder="Enter your full name"
                        required
                    >
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                    >
                </div>

                <div class="input-group">
                    <label>Phone Number</label>
                    <input
                        type="text"
                        name="phone"
                        placeholder="Enter 10 digit phone number"
                        required
                    >
                </div>

                <div class="input-group">
                    <label>Course</label>

                    <select name="course" required>
                        <option value="">Select your course</option>
                        <option value="CSE">Computer Science and Engineering</option>
                        <option value="IT">Information Technology</option>
                        <option value="ECE">Electronics and Communication</option>
                        <option value="Mechanical">Mechanical Engineering</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Message</label>

                    <textarea
                        name="message"
                        rows="4"
                        placeholder="Enter your message"
                    ></textarea>
                </div>

                <button type="submit">
                    Submit Registration
                </button>

            </form>

            <a class="back-link" href="../PRACTICAL-1/index.html">
                ← Back to Home
            </a>

        </div>

    </main>

    <footer>
        © 2026 CHARUSAT | CampusCore Student Portal
    </footer>

</div>

</body>
</html>
