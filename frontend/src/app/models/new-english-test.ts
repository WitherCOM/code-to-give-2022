import {EnglishLevel} from "./english-level";

export interface NewEnglishTest {
  "name": string,
  "level": EnglishLevel,
  "limit": number,
  "text_to_read": string,
  "essay_title": string,
  "questions": string[]
}
