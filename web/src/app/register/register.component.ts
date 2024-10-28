import { Component } from '@angular/core';
import { ApiService } from '../api.service';
import { CommonModule } from '@angular/common';  
import { FormsModule } from '@angular/forms';    
import { HttpErrorResponse } from '@angular/common/http';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  standalone: true,
  imports: [CommonModule, FormsModule],  
})
export class RegisterComponent {
  registrationData = { username: '', email: '', password: '', role: 'User' };
  errorMessage = '';
  successMessage = '';

  constructor(private apiService: ApiService) {}

  onSubmit() {
    this.apiService.register(this.registrationData).subscribe({
      next: (response) => {
        this.successMessage = 'Registration successful!';
        this.errorMessage = '';
        this.registrationData = { username: '', email: '', password: '', role: 'User' }; // Reset form
      },
      error: (err: HttpErrorResponse) => {
        this.errorMessage = 'Registration failed. Please try again.';
        this.successMessage = '';
      }
    });
  }
}
