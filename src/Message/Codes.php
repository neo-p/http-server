<?php

namespace NeoP\Http\Server\Message;

class Codes
{

    // Http Status
    // ---------------------------------------------------------------------
	const HTTP_CONTINUE = 100; // RFC 7231, 6.2.1
	const HTTP_SWITCHING_PROTOCOLS = 101; // RFC 7231, 6.2.2
	const HTTP_PROCESSING = 102; // RFC 2518, 10.1
	const HTTP_EARLY_HINTS = 103; // RFC 8297

	const HTTP_OK = 200; // RFC 7231, 6.3.1
	const HTTP_CREATED = 201; // RFC 7231, 6.3.2
	const HTTP_ACCEPTED = 202; // RFC 7231, 6.3.3
	const HTTP_NON_AUTHORITATIVE_INFO = 203; // RFC 7231, 6.3.4
	const HTTP_NO_CONTENT = 204; // RFC 7231, 6.3.5
	const HTTP_RESET_CONTENT = 205; // RFC 7231, 6.3.6
	const HTTP_PARTIAL_CONTENT = 206; // RFC 7233, 4.1
	const HTTP_MULTI_HTTP = 207; // RFC 4918, 11.1
	const HTTP_ALREADY_REPORTED = 208; // RFC 5842, 7.1
	const HTTP_IMUSED = 226; // RFC 3229, 10.4.1

	const HTTP_MULTIPLE_CHOICES = 300; // RFC 7231, 6.4.1
	const HTTP_MOVED_PERMANENTLY = 301; // RFC 7231, 6.4.2
	const HTTP_FOUND = 302; // RFC 7231, 6.4.3
	const HTTP_SEE_OTHER = 303; // RFC 7231, 6.4.4
	const HTTP_NOT_MODIFIED = 304; // RFC 7232, 4.1
	const HTTP_USE_PROXY = 305; // RFC 7231, 6.4.5

	const HTTP_TEMPORARY_REDIRECT = 307; // RFC 7231, 6.4.7
	const HTTP_PERMANENT_REDIRECT = 308; // RFC 7538, 3

	const HTTP_BAD_REQUEST = 400; // RFC 7231, 6.5.1
	const HTTP_UNAUTHORIZED = 401; // RFC 7235, 3.1
	const HTTP_PAYMENT_REQUIRED = 402; // RFC 7231, 6.5.2
	const HTTP_FORBIDDEN = 403; // RFC 7231, 6.5.3
	const HTTP_NOT_FOUND = 404; // RFC 7231, 6.5.4
	const HTTP_METHOD_NOT_ALLOWED = 405; // RFC 7231, 6.5.5
	const HTTP_NOT_ACCEPTABLE = 406; // RFC 7231, 6.5.6
	const HTTP_PROXY_AUTH_REQUIRED = 407; // RFC 7235, 3.2
	const HTTP_REQUEST_TIMEOUT = 408; // RFC 7231, 6.5.7
	const HTTP_CONFLICT = 409; // RFC 7231, 6.5.8
	const HTTP_GONE = 410; // RFC 7231, 6.5.9
	const HTTP_LENGTH_REQUIRED = 411; // RFC 7231, 6.5.10
	const HTTP_PRECONDITION_FAILED = 412; // RFC 7232, 4.2
	const HTTP_REQUEST_ENTITY_TOO_LARGE = 413; // RFC 7231, 6.5.11
	const HTTP_REQUEST_URITOO_LONG = 414; // RFC 7231, 6.5.12
	const HTTP_UNSUPPORTED_MEDIA_TYPE = 415; // RFC 7231, 6.5.13
	const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416; // RFC 7233, 4.4
	const HTTP_EXPECTATION_FAILED = 417; // RFC 7231, 6.5.14
	const HTTP_TEAPOT = 418; // RFC 7168, 2.3.3
	const HTTP_MISDIRECTED_REQUEST = 421; // RFC 7540, 9.1.2
	const HTTP_UNPROCESSABLE_ENTITY = 422; // RFC 4918, 11.2
	const HTTP_LOCKED = 423; // RFC 4918, 11.3
	const HTTP_FAILED_DEPENDENCY = 424; // RFC 4918, 11.4
	const HTTP_TOO_EARLY = 425; // RFC 8470, 5.2.
	const HTTP_UPGRADE_REQUIRED = 426; // RFC 7231, 6.5.15
	const HTTP_PRECONDITION_REQUIRED = 428; // RFC 6585, 3
	const HTTP_TOO_MANY_REQUESTS = 429; // RFC 6585, 4
	const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431; // RFC 6585, 5
	const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451; // RFC 7725, 3

	const HTTP_INTERNAL_SERVER_ERROR = 500; // RFC 7231, 6.6.1
	const HTTP_NOT_IMPLEMENTED = 501; // RFC 7231, 6.6.2
	const HTTP_BAD_GATEWAY = 502; // RFC 7231, 6.6.3
	const HTTP_SERVICE_UNAVAILABLE = 503; // RFC 7231, 6.6.4
	const HTTP_GATEWAY_TIMEOUT = 504; // RFC 7231, 6.6.5
	const HTTP_HTTPVERSION_NOT_SUPPORTED = 505; // RFC 7231, 6.6.6
	const HTTP_VARIANT_ALSO_NEGOTIATES = 506; // RFC 2295, 8.1
	const HTTP_INSUFFICIENT_STORAGE = 507; // RFC 4918, 11.5
	const HTTP_LOOP_DETECTED = 508; // RFC 5842, 7.2
	const HTTP_NOT_EXTENDED = 510; // RFC 2774, 7
	const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511; // RFC 6585, 6

    // ---------------------------------------------------------------------


    // Grpc Codes
    // ---------------------------------------------------------------------
    // OK is returned on success.
    const GRPC_OK = 0;

    // Canceled indicates the operation was canceled (typically by the caller).
    const GRPC_CANCELED = 1;

    // Unknown error. An example of where this error may be returned is
    // if a Status value received from another address space belongs to
    // an error-space that is not known in this address space. Also
    // errors raised by APIs that do not return enough error information
    // may be converted to this error.
    const GRPC_UNKNOWN = 2;

    // InvalidArgument indicates client specified an invalid argument.
    // Note that this differs from FailedPrecondition. It indicates arguments
    // that are problematic regardless of the state of the system
    // (e.g., a malformed file name).
    const GRPC_INVALID_ARGUMENT = 3;

    // DeadlineExceeded means operation expired before completion.
    // For operations that change the state of the system, this error may be
    // returned even if the operation has completed successfully. For
    // example, a successful response from a server could have been delayed
    // long enough for the deadline to expire.
    const GRPC_DEADLINE_EXCEEDED = 4;

    // NotFound means some requested entity (e.g., file or directory) was
    // not found.
    const GRPC_NOT_FOUND = 5;

    // AlreadyExists means an attempt to create an entity failed because one
    // already exists.
    const GRPC_ALREADY_EXISTS = 6;

    // PermissionDenied indicates the caller does not have permission to
    // execute the specified operation. It must not be used for rejections
    // caused by exhausting some resource (use ResourceExhausted
    // instead for those errors). It must not be
    // used if the caller cannot be identified (use Unauthenticated
    // instead for those errors).
    const GRPC_PERMISSION_DENIED = 7;

    // ResourceExhausted indicates some resource has been exhausted, perhaps
    // a per-user quota, or perhaps the entire file system is out of space.
    const GRPC_RESOURCE_EXHAUSTED = 8;

    // FailedPrecondition indicates operation was rejected because the
    // system is not in a state required for the operation's execution.
    // For example, directory to be deleted may be non-empty, an rmdir
    // operation is applied to a non-directory, etc.
    //
    // A litmus test that may help a service implementor in deciding
    // between FailedPrecondition, Aborted, and Unavailable:
    //  (a) Use Unavailable if the client can retry just the failing call.
    //  (b) Use Aborted if the client should retry at a higher-level
    //      (e.g., restarting a read-modify-write sequence).
    //  (c) Use FailedPrecondition if the client should not retry until
    //      the system state has been explicitly fixed. E.g., if an "rmdir"
    //      fails because the directory is non-empty, FailedPrecondition
    //      should be returned since the client should not retry unless
    //      they have first fixed up the directory by deleting files from it.
    //  (d) Use FailedPrecondition if the client performs conditional
    //      REST Get/Update/Delete on a resource and the resource on the
    //      server does not match the condition. E.g., conflicting
    //      read-modify-write on the same resource.
    const GRPC_FAILED_PRECONDITION = 9;

    // Aborted indicates the operation was aborted, typically due to a
    // concurrency issue like sequencer check failures, transaction aborts,
    // etc.
    //
    // See litmus test above for deciding between FailedPrecondition,
    // Aborted, and Unavailable.
    const GRPC_ABORTED = 10;

    // OutOfRange means operation was attempted past the valid range.
    // E.g., seeking or reading past end of file.
    //
    // Unlike InvalidArgument, this error indicates a problem that may
    // be fixed if the system state changes. For example, a 32-bit file
    // system will generate InvalidArgument if asked to read at an
    // offset that is not in the range [0,2^32-1], but it will generate
    // OutOfRange if asked to read from an offset past the current
    // file size.
    //
    // There is a fair bit of overlap between FailedPrecondition and
    // OutOfRange. We recommend using OutOfRange (the more specific
    // error) when it applies so that callers who are iterating through
    // a space can easily look for an OutOfRange error to detect when
    // they are done.
    const GRPC_OUT_OF_RANGE = 11;

    // Unimplemented indicates operation is not implemented or not
    // supported/enabled in this service.
    const GRPC_UNIMPLEMENTED = 12;

    // Internal errors. Means some invariants expected by underlying
    // system has been broken. If you see one of these errors,
    // something is very broken.
    const GRPC_INTERNAL = 13;

    // Unavailable indicates the service is currently unavailable.
    // This is a most likely a transient condition and may be corrected
    // by retrying with a backoff. Note that it is not always safe to retry
    // non-idempotent operations.
    //
    // See litmus test above for deciding between FailedPrecondition,
    // Aborted, and Unavailable.
    const GRPC_UNAVAILABLE = 14;

    // DataLoss indicates unrecoverable data loss or corruption.
    const GRPC_DATA_LOSS = 15;

    // Unauthenticated indicates the request does not have valid
    // authentication credentials for the operation.
    const GRPC_UNAUTHENTICATED = 16;

    // ---------------------------------------------------------------------
    
    // /**
    //  * @see https://grpc.github.io/grpc/core/md_doc_statuscodes.html
    //  */
    // const HTTP_CODE_MAPPING = [
    //     self::OK => 200,
    //     self::CANCELLED => 499,
    //     self::UNKNOWN => 500,
    //     self::INVALID_ARGUMENT => 400,
    //     self::DEADLINE_EXCEEDED => 504,
    //     self::NOT_FOUND => 404,
    //     self::ALREADY_EXISTS => 409,
    //     self::PERMISSION_DENIED => 403,
    //     self::RESOURCE_EXHAUSTED => 429,
    //     self::FAILED_PRECONDITION => 400,
    //     self::ABORTED => 409,
    //     self::OUT_OF_RANGE => 400,
    //     self::UNIMPLEMENTED => 501,
    //     self::INTERNAL => 500,
    //     self::UNAVAILABLE => 503,
    //     self::DATA_LOSS => 500,
    //     self::UNAUTHENTICATED => 401,
    // ];
}
