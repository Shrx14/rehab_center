# Web-based MIS for Rehabilitation Center

This project is a web-based Management Information System (MIS) designed for a Rehabilitation Center. It aims to streamline operations and improve record management. Follow the instructions below to set up and run the project on your local machine.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Database Setup](#database-setup)
- [Tech Stack](#tech-stack)
- [Contributing](#contributing)
- [License](#license)

## Features
- User-friendly interface for managing patient records.
- Report generation for administrative purposes.
- Secure login for staff and administrators.
- Role-based access control.

## Installation

1. **Download the Project Files**:
   - Extract the provided `.zip` file into the `htdocs` folder of your XAMPP installation directory. Typically, this is located at `C:\xampp\htdocs`.

2. **Start XAMPP**:
   - Open the XAMPP Control Panel and start the `Apache` and `MySQL` services.

3. **Access the Application**:
   - Open your web browser and navigate to `http://localhost/{your-folder-name}`.
   - Replace `{your-folder-name}` with the name of the folder where you extracted the project files.

## Database Setup

1. **Import the Database**:
   - Open the XAMPP MySQL portal by navigating to `http://localhost/phpmyadmin`.
   - Create a new database named `rehab_center`.
   - Use the `Import` functionality to upload the `rehab_center.sql` file provided with the project.

2. **Verify Tables**:
   - Ensure that all tables have been imported correctly.

## Usage

- Once the setup is complete, log in using the default credentials provided in the project documentation (or as configured during setup).
- Use the system features to manage records, generate reports, and perform administrative tasks.

## Tech Stack
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Platform**: XAMPP

## Contributing
Contributions are welcome! If you'd like to contribute to this project, please fork the repository and submit a pull request with your changes.

## Collaborators
- Pratiksha Patil https://github.com/Pratikshaa8
- Srujan Yadav https://github.com/SrujaN1906

## License
[MIT License](LICENSE)

---

Feel free to reach out if you encounter any issues or have suggestions for improvement.
