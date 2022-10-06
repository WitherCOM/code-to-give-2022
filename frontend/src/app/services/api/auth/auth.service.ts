import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {Register} from "../../../models/register";
import {catchError, Observable, of, tap} from "rxjs";
import {Login} from "../../../models/login";

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  public readonly basePath = 'https://codetogive2022.finch.hu/api/';

  public jwt = '';

  constructor(private readonly http: HttpClient) { }

  public register(data: Register): Observable<any> {
    const url = this.basePath + 'register';
    return this.http.post(url, data).pipe(
      tap({
        next: data => {
          console.log('Successful request:', data);
        },
        error: err => {
          console.error('Error during register:', err);
        }
      })
    )
  }

  public login(data: Login): Observable<boolean> {
    const url = this.basePath + 'login';
    console.log('Loggin\' in:', url);
    return this.http.post(url, data).pipe(
      tap({
        next: (data: any) => {
          this.jwt = data.jwt;
          console.log('Successful login ;)')
        },
        error: message => {
          console.error('Error during login:', message);
        }
      })
    )
  }

  public getBearer(): string {
    return this.jwt && 'Bearer ' + this.jwt;
  }
}
