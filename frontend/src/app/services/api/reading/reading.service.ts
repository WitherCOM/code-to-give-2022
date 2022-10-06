import {Injectable} from '@angular/core';
import {ReadingComprehensionTask} from "../../../models/reading-comprehension-task";
import {Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";
import {AuthService} from "../auth/auth.service";

@Injectable({
  providedIn: 'root'
})
export class ReadingssService {

  public readonly basePath = 'https://codetogive2022.finch.hu/api/';

  constructor(
    private readonly http: HttpClient,
    private readonly authService: AuthService
  ) {
  }

  getReadingComprehension(): Observable<ReadingComprehensionTask> {
    // return of({
    //   text: 'This is a very long test. Yout should read this until the end, and answer the questions',
    //   questions: [
    //     'First word?',
    //     'Best song ever?'
    //   ]
    // });
    const url = this.basePath + 'english_test'
    return this.http.get<ReadingComprehensionTask>(url, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    });
  }
}
