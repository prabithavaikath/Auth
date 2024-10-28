import { Routes } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard.component';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';

export const routes: Routes = [
  { path: '', component: LoginComponent },            // Set LoginComponent as the default homepage
  { path: 'login', component: LoginComponent },       
  { path: 'register', component: RegisterComponent },
  { path: 'dashboard', component: DashboardComponent },
  { path: '**', redirectTo: 'login' },                // Redirect unknown paths to the login page
];
