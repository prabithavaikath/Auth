import { Routes } from '@angular/router';
import { DashboardComponent } from './dashboard/dashboard.component';
import { AdminDashboardComponent } from './admin-dashboard/admin-dashboard.component';
import {SuperadminDashboardComponent} from './superadmin-dashboard/superadmin-dashboard.component';
import { LoginComponent } from './login/login.component';

export const routes: Routes = [
  { path: '', component: LoginComponent }, // Default homepage
  { path: 'login', component: LoginComponent },
  { path: 'dashboard', component: DashboardComponent, data: { role: 'User' } },
  { path: 'admin-dashboard', component: AdminDashboardComponent, data: { role: 'Admin' } },
  { path: 'superadmin-dashboard', component: SuperadminDashboardComponent, data: { role: 'SuperAdmin' } },
  { path: '**', redirectTo: 'login' }
];
