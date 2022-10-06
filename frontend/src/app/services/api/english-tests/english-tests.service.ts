import {Injectable} from '@angular/core';
import {HttpClient} from "@angular/common/http";
import {AuthService} from "../auth/auth.service";
import {catchError, Observable, of} from "rxjs";
import {NewEnglishTest} from "../../../models/new-english-test";
import {Response} from "../../../models/response";
import {EnglishLevel} from "../../../models/english-level";

@Injectable({
  providedIn: 'root'
})
export class EnglishTestsService {

  public readonly basePath = 'https://codetogive2022.finch.hu/api/english_test';

  constructor(private readonly http: HttpClient, private readonly authService: AuthService) {
  }

  newTest(newTestData: NewEnglishTest): Observable<Response> {
    const url = this.basePath;
    return this.http.post<Response>(url, newTestData, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    });
  }

  getTest(testId: string): Observable<{ data?: {}[], message?: string }> {
    const url = this.basePath + '/' + testId;
    return this.http.get(url, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    });
  }

  getTests(): Observable<{ data: NewEnglishTest[] }> {
    const url = this.basePath;
    return this.http.get<{ data: NewEnglishTest[] }>(url, {
      headers: {
        'Authentication': this.authService.getBearer()
      }
    }).pipe(catchError(() => {
      console.log('No BE return fix data');
      return of({
        data: [{
          essay_title: "Math in the 19th century",
          level: EnglishLevel.ELEMENTARY,
          limit: 5,
          name: "Math thematic test",
          questions: [
            'Who was Aladar?',
            'Where was Thomas?',
            'How many dogs were in the kitchen?',
            'Who was Aladar?',
            'Where was Thomas?',
            'How many dogs were in the kitchen?',
            'Who was Aladar?',
            'Where was Thomas?',
            'How many dogs were in the kitchen?',
            'Where did Aliz find the keys?'
          ],
          text_to_read: "Once upon a time Aladar a 30 years old web developer went for a walk. Thomas slept in his house. While Thomas was sleeping all of his 3 dogs played with the cat, until Aliz found her key in her pocket."
        }]
      })
    }));
  }
}
