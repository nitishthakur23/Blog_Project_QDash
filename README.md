
---

# QDash

QDash is a dynamic blog website built with PHP and MySQL, utilizing Bootstrap and jQuery for a responsive and interactive user experience. Users can post blogs, switch between light and dark themes, categorize posts, interact with content, and follow other users. The site includes email subscription functionality via PHPMailer and much more.

## Features

- **User Authentication**: Secure sign-up and log-in functionality.
- **Blog Posting**: Create, edit, and delete blog posts from a personalized dashboard.
- **Responsive Design**: Built with Bootstrap for a mobile-friendly layout.
- **Theme Toggle**: Switch between white and dark themes with a button.
- **Category Browsing**: View blog posts by category.
- **Interaction Features**: Like, save, and comment on blog posts.
- **Views Counter**: Track the number of views on each blog post.
- **User Profiles**: View and follow other users' profiles.
- **Email Subscription**: Subscribe to updates using PHPMailer.
- **Dashboard**: Manage your posts and profile from a user-specific dashboard.

## Demo

![QDash Demo Video](link-to-your-video) *(Replace with the actual link)*

## Installation

To set up QDash locally on your machine, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/QDash.git
   cd QDash
   ```

2. **Set up your environment:**
   Ensure you have PHP, MySQL, and Composer installed on your machine.

3. **Install dependencies:**
   ```bash
   composer install
   ```

4. **Create a database:**
   Create a new MySQL database and import the provided SQL file (`qdash.sql`) to set up the necessary tables.

5. **Configure environment variables:**
   Create a `.env` file in the root directory and add your configuration settings.
   ```env
   DB_HOST=your_database_host
   DB_NAME=your_database_name
   DB_USER=your_database_user
   DB_PASS=your_database_password
   DB_NAME=your_database_name
   SMTP_HOST=your_smtp_host
   SMTP_PASS=your_smtp_password
   ```

6. **Start the development server:**
   Place the project in your web server's root directory (e.g., `htdocs` for XAMPP) and start your server.

7. **Open your browser and visit:**
   ```
   http://localhost/QDash
   ```

## Usage

SetUp the database by creating tables.

1. **Sign Up or Log In:**
   - Create a new account or log in to an existing account.

2. **Create a Blog Post:**
   - Navigate to your dashboard and click on "New Post" to create a blog.
   - Add a title, content, tags, and select a category.
   - Save the post to publish it.

3. **Explore and Interact:**
   - Browse posts by category or search for specific topics.
   - Like, save, comment on posts, and track the view counts.
   - Follow other users and view their profiles.

4. **Email Subscription:**
   - Subscribe to blog updates using the email subscription feature powered by PHPMailer.

## Contributing

We welcome contributions to QDash! To contribute, follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature-name`).
3. Make your changes and commit them (`git commit -m 'Add some feature'`).
4. Push to the branch (`git push origin feature/your-feature-name`).
5. Open a pull request.

## License

QDash is open-source software licensed under the MIT license.

---
