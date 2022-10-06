import { TestBed } from '@angular/core/testing';

import { EnglishTestsService } from './english-tests.service';

describe('EnglishTestsService', () => {
  let service: EnglishTestsService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(EnglishTestsService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
