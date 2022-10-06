import {Component, OnInit} from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {EnglishTestsService} from "../../services/api/english-tests/english-tests.service";
import {EnglishLevel} from "../../models/english-level";

@Component({
  selector: 'app-create-survey',
  templateUrl: './create-survey.component.html',
  styleUrls: ['./create-survey.component.scss']
})
export class CreateSurveyComponent implements OnInit {
  taskForm: FormGroup = new FormGroup({});

  constructor(private readonly englishTestsService: EnglishTestsService) {
  }

  ngOnInit(): void {
    this.taskForm = new FormGroup({
      'name': new FormControl(null, [Validators.required]),
      'essay_title': new FormControl(null, [Validators.required]),
      'limit': new FormControl(null, [Validators.required]),
      'question0': new FormControl(null, [Validators.required]),
      'question1': new FormControl(null, [Validators.required]),
      'question2': new FormControl(null, [Validators.required]),
      'question3': new FormControl(null, [Validators.required]),
      'question4': new FormControl(null, [Validators.required]),
      'question5': new FormControl(null, [Validators.required]),
      'question6': new FormControl(null, [Validators.required]),
      'question7': new FormControl(null, [Validators.required]),
      'question8': new FormControl(null, [Validators.required]),
      'question9': new FormControl(null, [Validators.required]),
      'text_to_read': new FormControl(null, [Validators.required]),
    });
  }

  onSubmit() {
    this.englishTestsService.newTest({
      name: this.taskForm.value.name,
      essay_title: this.taskForm.value.essay_title,
      level: EnglishLevel.ELEMENTARY,
      limit: this.taskForm.value.limit,
      questions: [
        this.taskForm.value.question0,
        this.taskForm.value.question1,
        this.taskForm.value.question2,
        this.taskForm.value.question3,
        this.taskForm.value.question4,
        this.taskForm.value.question5,
        this.taskForm.value.question6,
        this.taskForm.value.question7,
        this.taskForm.value.question8,
        this.taskForm.value.question9
      ],
      text_to_read: ""
    })
  }
}
