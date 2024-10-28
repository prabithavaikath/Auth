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
        localStorage.setItem('token', response.token); // Store token if received
        this.router.navigate(['/dashboard']);           // Redirect to dashboard
      },
      error: (err: HttpErrorResponse) => {
        this.errorMessage = err.error?.message || 'Login failed. Please try again.';
      }
    });
  }
}
