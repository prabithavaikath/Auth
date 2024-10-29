import { Component, OnInit } from '@angular/core';
import { ApiService } from '../api.service';
import { HttpErrorResponse } from '@angular/common/http';
import { CommonModule } from '@angular/common'; // Import CommonModule

@Component({
  selector: 'app-superadmin-dashboard',
  standalone: true,
  imports: [CommonModule],  // Make sure CommonModule is listed here
  templateUrl: './superadmin-dashboard.component.html',
  styleUrls: ['./superadmin-dashboard.component.css']
})
export class SuperadminDashboardComponent implements OnInit {
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
}
