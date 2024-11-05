import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import { catchError, switchMap } from 'rxjs/operators';
import { throwError, of } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private apiUrl = 'http://localhost:8081'; // Adjust to your backend URL
  private accessTokenKey = 'access_token';
  private refreshTokenKey = 'refresh_token';
  constructor(private http: HttpClient) {}


  private getAuthHeaders(): HttpHeaders {
    const token = localStorage.getItem('token');
    return new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    });
  }

    // Refresh token method
    refreshToken(): Observable<any> {
      const refreshToken = localStorage.getItem(this.refreshTokenKey);
      const headers = new HttpHeaders().set('Content-Type', 'application/json');
      return this.http.post<any>(`${this.apiUrl}/refresh-token`, { refreshToken }, { headers }).pipe(
        tap((tokens: any) => {
          // Update tokens in local storage
          localStorage.setItem(this.accessTokenKey, tokens.accessToken);
          localStorage.setItem(this.refreshTokenKey, tokens.refreshToken);
        })
      );
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
  fetchDataBasedOnRole(): Observable<any> {
    const headers = this.getAuthHeaders();
    return this.http.get(`${this.apiUrl}/fetch-data`, { headers });
  }
  // deleteUser(userId: number): Observable<any> {
  //   const headers = this.getAuthHeaders();
  //   return this.http.delete(`${this.apiUrl}/users/${userId}`, { headers });
  // }
  // deleteUser(userId: number): Observable<any> {
  //   const headers = this.getAuthHeaders();

  
  //   return this.http.delete(`${this.apiUrl}/users/${userId}`, { headers });
    
  // }

  getAccessToken(): string | null {
    return localStorage.getItem(this.accessTokenKey);
  }

  getRefreshToken(): string | null {
    return localStorage.getItem(this.refreshTokenKey);
  }
// Inside AuthService or a similar service
deleteUser(userId: number): Observable<any> {
  const headers = this.getAuthHeaders();
  return this.http.delete(`${this.apiUrl}/users/${userId}`, { headers })
    .pipe(
      catchError(error => {
        if (error.status === 401) {
          // Handle expired token or invalid token
          return this.refreshToken().pipe(
            switchMap(() => this.deleteUser(userId))
          );
        } else {
          // Handle other errors
          throw error;
        }
      })
    );
}
  updateUser(userId: number, updatedData: any): Observable<any> {
    const headers = this.getAuthHeaders();
    return this.http.put(`${this.apiUrl}/users/${userId}`, updatedData, { headers });
  }
}
