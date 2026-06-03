<?php

namespace App\Enums;

enum CourseType: string
{
    case SelfPaced = 'self-paced';
    case Cohort = 'cohort';
    case Live = 'live';
}
