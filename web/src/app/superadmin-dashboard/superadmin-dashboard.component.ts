import { Component, OnInit } from '@angular/core';
import { ApiService } from '../api.service';
import { HttpErrorResponse } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { MatDialog } from '@angular/material/dialog';
import { EditUserDialogComponent } from './edit-user-dialog/edit-user-dialog.component';
import { Router } from '@angular/router';


@Component({
  selector: 'app-superadmin-dashboard',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './superadmin-dashboard.component.html',
  styleUrls: ['./superadmin-dashboard.component.css']
})
export class SuperadminDashboardComponent implements OnInit {
  userData: any[] = [];
  errorMessage: string = '';

  constructor(private apiService: ApiService, private dialog: MatDialog) {} // Inject MatDialog

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

  // deleteUser(userId: number) {
  //   if (confirm('Are you sure you want to delete this user?')) {
  //     this.apiService.deleteUser(userId).subscribe({
  //       next: () => {
  //         this.userData = this.userData.filter(user => user.id !== userId);
  //       },
  //       error: (err: HttpErrorResponse) => {
  //         this.errorMessage = 'Failed to delete user: ' + (err.error.message || err.message);
  //       }
  //     });
  //   }
  // }
  deleteUser(userId: number) {
    console.log(`deleteUser method called with userId: ${userId}`);
    console.log('Before confirm dialog');
    //this.apiService.deleteUser(userId).subscribe(() => console.log("user deleted"));   
    if (confirm('Are you sure you want to delete this user?')) {
      this.apiService.deleteUser(userId).subscribe({
        next: () => {
          console.log("User deleted");
          // Additional logic like updating the UI or state
        },
        error: (err) => console.error("Failed to delete user", err),
      });
    } else {
      console.log('User canceled deletion.');
    }
    
  }
  
  
  editUser(user: any) {
    // Open the edit dialog and pass the user data
    const dialogRef = this.dialog.open(EditUserDialogComponent, {
      width: '400px',
      data: user
    });

    // Handle the result after the dialog closes
    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.updateUserData(result);
      }
    });
  }

  // Method to update user data in the local list after editing
  updateUserData(updatedUser: any) {
    const index = this.userData.findIndex(user => user.id === updatedUser.id);
    if (index > -1) {
      this.userData[index] = updatedUser;
    }
  }
}
