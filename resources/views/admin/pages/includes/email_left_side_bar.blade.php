<div class="email-leftbar card">
    <button type="button" class="btn btn-danger w-100 waves-effect waves-light" data-bs-toggle="modal"
        data-bs-target="#composemodal">
        Compose
    </button>
    <div class="mail-list mt-4">
        <a href="{{ route('admin.email.index') }}" class="
        @if (Route::currentRouteName()=='admin.email.index') active
        @endif
        "><i class="mdi mdi-email-outline me-2"></i> Inbox <span
                class="ms-1 float-end">
                @if ($allEmailInfo['totalEmail'] ==0)
                @else
                ({{$allEmailInfo['totalEmail']  }})
                @endif
            </span></a>

        <a  class="
        @if (Route::currentRouteName()=='admin.email.allUnreadEmail') active
        @endif"   href="{{ route('admin.email.allUnreadEmail') }}"><i class="me-1 mdi mdi-email-mark-as-unread"></i>  Unread <span
            class="ms-1 float-end">
            @if ($allEmailInfo['totalUnreadEmail'] ==0)
            @else
            ({{$allEmailInfo['totalUnreadEmail']  }})
            @endif</span>
        </a>

        <a class="
        @if (Route::currentRouteName()=='admin.email.allSentEmail') active
        @endif" href="{{ route('admin.email.allSentEmail') }}"><i class="mdi mdi-email-check-outline me-2"></i>Sent Mail</a>
        <a class="
        @if (Route::currentRouteName()=='admin.email.trash') active
        @endif" href="{{ route('admin.email.trash') }}"><i class="mdi mdi-trash-can-outline me-2"></i>Trash
        <span
        class="ms-1 float-end">
        @if ($allEmailInfo['totalTrashEmail'] ==0)
        @else
        ({{$allEmailInfo['totalTrashEmail']  }})
        @endif</span>

    </a>


    </div>

</div>
