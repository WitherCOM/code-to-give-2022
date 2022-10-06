import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {AuthService} from "../../services/api/auth/auth.service";
import {Register} from "../../models/register";
import {Login} from "../../models/login";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup = new FormGroup({});

  errorMsg = '';

  constructor(private readonly authService: AuthService) {
  }

  ngOnInit(): void {
    this.loginForm = new FormGroup({
      'email': new FormControl(null, [Validators.required, Validators.email]),
      'password': new FormControl(null, [Validators.required, Validators.minLength(6)])
    });

    this.loginForm.valueChanges.subscribe(() => this.errorMsg = '')
  }

  onSubmit() {
    console.log(this.loginForm);
    const loginData: Login = {
      email: this.loginForm.value.email,
      password: this.loginForm.value.password
    }
    this.authService.login(loginData).subscribe({
      next: value => {
        console.log('Successful login', value);
      },
      error: err => {
        console.error('Unsuccessful login', err);
        this.errorMsg = err.error.message;
      }
    })
  }
}
