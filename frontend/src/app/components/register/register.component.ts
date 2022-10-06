import {Component, OnInit} from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {AuthService} from "../../services/api/auth/auth.service";
import {Register} from "../../models/register";

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  registerForm: FormGroup = new FormGroup({});

  errorMsg = '';

  constructor(private readonly authService: AuthService) {
  }

  ngOnInit(): void {
    this.registerForm = new FormGroup({
      'name': new FormControl(null, [Validators.required]),
      'email': new FormControl(null, [Validators.required, Validators.email]),
      'password': new FormControl(null, [Validators.required, Validators.minLength(6)])
    });

    this.registerForm.valueChanges.subscribe(() => this.errorMsg = '')
  }

  onSubmit() {
    console.log(this.registerForm);
    const registrationData: Register = {
      email: this.registerForm.value.email,
      name: this.registerForm.value.name,
      password: this.registerForm.value.password
    }
    this.authService.register(registrationData).subscribe({
      next: value => {
        console.log('Successful register', value);
      },
      error: err => {
        console.error('Unsuccessful registration', err);
        this.errorMsg = err.error.message;
      }
    })
  }
}
