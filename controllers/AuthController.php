<?php

  class AuthController extends Controller {

    public function login() {
      session_start();
      if (isset($_SESSION['user'])) {
        header("Location:?c=dashboard&m=index");
        exit();
      }

      $this->loadView("auth/login", ['title' => 'Login'], "auth");
    }

    public function loginProcess() {
      session_start();

      $username = $_POST['username'] ?? '';
      $password = $_POST['password'] ?? '';

      $userModel = $this->loadModel("user");
      $user = $userModel->getByUsername($username);

      if ($user && password_verify($password, $user->password)) {
          $_SESSION['user'] = [
              'id' => $user->id,
              'username' => $user->username
          ];
          header("Location:?c=dashboard&m=index");
          exit();
      } else {
          $this->loadView("auth/login", [
              'title' => 'Login',
              'error' => 'Username atau password salah'
          ], 'auth');
      }
    }


    public function register() {
      session_start();
      if (isset($_SESSION['user'])) {
        header("Location:?c=dashboard&m=index");
        exit();
      }

      $this->loadView("auth/register", ['title' => 'Register'], "auth");
    }

    public function registerProcess() {
      $username = $_POST['username'] ?? '';
      $fullName = $_POST['full_name'] ?? '';
      $email = $_POST['email'] ?? '';
      $telepon = $_POST['telepon'] ?? '';
      $password = $_POST['password'] ?? '';
      $confirmPassword = $_POST['confirm'] ?? '';

  if ($password !== $confirmPassword) {
    return $this->loadView("auth/register", [
      'title' => 'Register',
      'error' => 'Password tidak sama'
    ], 'auth');
  }

  $userModel = $this->loadModel("user");

  if ($userModel->getByUsername($username)) {
    return $this->loadView("auth/register", [
      'title' => 'Register',
      'error' => 'Username sudah digunakan'
    ], 'auth');
  }

  if ($userModel->getByEmail($email)) {
    return $this->loadView("auth/register", [
      'title' => 'Register',
      'error' => 'Email sudah terdaftar'
    ], 'auth');
  }

  $userModel->create($username, $fullName, $email, $telepon, $password);
  header("Location:?c=auth&m=login");
  exit();
    }

    public function logout() {
      session_start();
      session_destroy();
      header("Location:?c=auth&m=login");
      exit();
    }
  }
