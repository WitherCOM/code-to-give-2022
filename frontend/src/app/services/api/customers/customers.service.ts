import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {NewCustomer} from "../../../models/new-customer";
import {Observable} from "rxjs";
import {AuthService} from "../auth/auth.service";

@Injectable({
  providedIn: 'root'
})
export class CustomersService {

  public readonly basePath = 'https://codetogive2022.finch.hu/api/customer';

  constructor(private readonly http: HttpClient, private readonly authService: AuthService) { }

  newUser(newCustomerData: NewCustomer): Observable<{ message: string, customer_id: string }> {
    const url = this.basePath;
    return this.http.post(url, newCustomerData, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    });
  }

  getCustomer(userId: string): Observable<any> {
    const url = this.basePath + '/' + userId;
    return this.http.get(url, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    });
  }

  getCustomers(): Observable<any> {
    const url = this.basePath;
    return this.http.get(url, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    });
  }

  updateCustomer(newCustomerData: NewCustomer, id: string): Observable<any> {
    const url = this.basePath + '/' + id;
    return this.http.patch(url, newCustomerData, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    });
  }

  removeCustomer(id: string): Observable<any> {
    const url = this.basePath + '/' + id;
    return this.http.delete(url, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    });
  }
}
