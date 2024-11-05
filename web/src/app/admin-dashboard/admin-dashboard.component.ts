import { Component, OnInit } from '@angular/core';
import { ApiService } from '../api.service';
import { HttpErrorResponse } from '@angular/common/http';
import { CommonModule } from '@angular/common'; // Import CommonModule
import { Router } from '@angular/router';
@Component({
  selector: 'app-admin-dashboard',
  standalone: true,
  imports: [CommonModule],  // Ensure CommonModule is in the imports array
  templateUrl: './admin-dashboard.component.html',
  styleUrls: ['./admin-dashboard.component.css']
})
export class AdminDashboardComponent implements OnInit {
  userData: any[] = [];
  errorMessage: string = '';

  constructor(private apiService: ApiService) {}

  ngOnInit(): void {
    this.loadUserData();
  }

  loadUserData() {
    this.apiService.fetchDataBasedOnRole().subscribe({
      next: (data: any) => {
        this.userData = data;
      },
      error: (err: HttpErrorResponse) => {
        this.errorMessage = 'Failed to load data: ' + (err.error.message || err.message);
      }
    });
  }

  deleteUser(userId: number) {
    if (confirm('Are you sure you want to delete this user?')) {
      this.apiService.deleteUser(userId).subscribe({
        next: () => {
          this.userData = this.userData.filter(user => user.id !== userId);
        },
        error: (err: HttpErrorResponse) => {
          this.errorMessage = 'Failed to delete user: ' + (err.error.message || err.message);
        }
      });
    }
  }
}
