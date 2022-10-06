import {Component, OnInit} from '@angular/core';
import {EnglishTestsService} from "../../../../services/api/english-tests/english-tests.service";
import {NewEnglishTest} from "../../../../models/new-english-test";
import {EnglishLevel} from "../../../../models/english-level";
import {FormGroup} from "@angular/forms";

@Component({
  selector: 'app-reading-comprehension',
  templateUrl: './reading-comprehension.component.html',
  styleUrls: ['./reading-comprehension.component.scss']
})
export class ReadingComprehensionComponent implements OnInit {

  testForm: FormGroup = new FormGroup({});

  public task: NewEnglishTest = {
    essay_title: "",
    level: EnglishLevel.ELEMENTARY,
    limit: 0,
    name: "",
    questions: [],
    text_to_read: ""
  };

  constructor(public readonly englishTestsService: EnglishTestsService) {
    englishTestsService.getTests().subscribe(data => {
      this.task = data.data[0];
    });
  }

  ngOnInit(): void {
  }

  onSubmit() {
    console.log('Submitted');
  }
}
