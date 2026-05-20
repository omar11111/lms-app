<?php

namespace App\Enums;

enum CourseStatus: string
{
    case Draft = 'draft';

    case Published = 'published';

    case Archived = 'archived';

    case PendingReview = 'pending_review';

    case Featured = 'Featured';
}
