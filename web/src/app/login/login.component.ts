import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ApiService } from '../api.service';
import { HttpErrorResponse } from '@angular/common/http';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  credentials = { username: '', password: '' };
  errorMessage = '';

  constructor(private apiService: ApiService, private router: Router) {}

  onSubmit() {
    this.apiService.login(this.credentials).subscribe({
      next: (response) => {
        // Assuming the response contains both `token` and `role` properties
        localStorage.setItem('token', response.token);       // Store the JWT token
        localStorage.setItem('role', response.role);         // Store the user role

        // Redirect based on the user's role
        if (response.role == 'User') {
          this.router.navigate(['/dashboard']);
        } else if (response.role == 'Admin') {
          this.router.navigate(['/admin-dashboard']);
        } else if (response.role == 'SuperAdmin') {
          this.router.navigate(['/superadmin-dashboard']);
        }
      },
      error: (err: HttpErrorResponse) => {
        this.errorMessage = err.error?.message || 'Login failed. Please try again.';
      }
    });
  }
}
