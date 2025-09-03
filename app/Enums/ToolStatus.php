<?php

namespace App\Enums;

enum ToolStatus: string
{
    case processing = "processing";
    case complete =  "complete";
    case failed = "failed";
}
