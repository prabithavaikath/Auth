import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';


@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private apiUrl = 'http://localhost:8081'; // Adjust to your backend URL

  constructor(private http: HttpClient) {}


  private getAuthHeaders(): HttpHeaders {
    const token = localStorage.getItem('token');
    return new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  }
  //login method
  login(credentials: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/login`, credentials);
  }
  // Register method
  register(userData: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/register`, userData, {
      headers: this.getAuthHeaders()
    });
  }
  //lIST uSERS
  getUserDataList(): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/users`, {
      headers: this.getAuthHeaders()
    });
  }


}
