Security aspects in software development
========================================

:lecturer:		Daniel Hein
:date:          winter term 2013/14
                but slides taken from winter term 2012/13

Introduction
------------

Problems:
- Software design process
- Faulty requirements
- architectural flaws
- implementation flaws

* Software vulnerabilities
    - Cross-Site scripting (XSS)
    - SQL injections
    - Buffer overflows
* Misconfiguration
    - default passwords
    - misconfigured services
* Malware
    - {Viruses, Worms, Trojans}
* Attacks
    - DoS, Phishing, Spam, Fraud, Identity theft, espionage

Security issues:
* Complex, interconnected systems (complexity leads to bugs, internet allows remote attacks)
* Old software (designed for a different environment, attacks were unknown, uneducated developers)

Security in new software:
* Benefit of security (return of investment)
* Lacking awareness (SQL injection)
* Hackers underestimated
* Flaws in employed technologies

Improvements in recent times:
* Internet becomes business platform with more attention (eg. e-banking, shopping, investigation, B2B)
* Increasing public awareness
* Negative publicity

Risk management / Security by design:
1. define assets
2. identify threats
3. assess risks (criticality, likelihood)
4. manage risks (employ security mechanisms, select technologies)

Project security goals:
1. Define security goals (prevent customer data theft).
2. Specify operation environment (demilitarized zone, high-security zone).
3. Define security policy (write it down, define security).
4. Security goals (design & implementation).
5. System must enforce policy and operation environment.

Security goals:
* Prevention
* Traceability and auditing
* Monitoring
* Privacy and confidentiality
* Multilevel security
* Anonymity

Security services:
* Confidentiality (Conceal, access restriction)
* Integrity (trustworthiness, protection of {data, origin, program} integrity and detection of invalidity)
* Availability (unexpected usage of DoS attack)

* Access control (authentication, authorization)
* Network traffic analysis / filtering
* Secure channels / messaging
* Trusted computing
* Cryptographic primitives

SQL injection
-------------

Mixing data and code in SQL (special purpose language for
relational database systems).

Impacts
* Unauthorized data access (identity theft, fraud, industrial espionage)
* Unauthorized data manipulation (new root user, denial of service, data removal)

Attack vectors
* Request parameters
* Cookies

Blind SQL injection
  injection query results are invisible
  Use side channels (error messages, time)
  Request results in other SQL query of different <form>

Mitigation
* Input sanitization (whitelisting, blacklisting, proper escaping)
* Prepared statements
* Stored procedures
* Database views
* Principle of least privilege for database access

Input sanitization
* proper escaping for special characters (RTFM)
* whitelisting (not all characters allowed)
* blacklisting (escape/remove special characters)
+ Input type checking
+ Implementations available (mysqli_real_escape_string, urlencode)
- Error prone (incomplete lists, character set conversion)

Prepared statements
* Programmer specifies code. Data is provided separately.

Stored procedures
* Precompiled procedures
* Program logic/code is hidden
* Prevents direct database access
* Parameter type checking
* Depends on procedure but SQL injection might still be possible

Database views (virtual tables)
* example "CREATE VIEW `temp_view` AS SELECT `name,age` FROM `clients`;"
* Minimizes data access
* Separate views for groups and users

Database access control
* example "GRANT privilege ON object TO entity"
* Minimize access right (principle of least privilege)
* Object permissions, statement permissions, implied permissions
* Limit Remote Database Management System Access logically and physically
* End-to-End secure communication
* One user per application
* For multi-tier application: One user per client

Data storage
* Limit storage of passwords, credit card information, ... (sensitive data)
* Check storage in terms of legislative, contractual, privacy policy and requirements
* Do not store passwords in plain text (pseudo-random function, hashing, salts)

Cross Site Scripting
--------------------

General XSS
  - injecting code into web page
Reflective XSS
  Entering malicious data into <form>
  Malicious code is executed in client and reflected in the form response
  Ephemeral code injection
Persistent XSS
  Malicious code is stored persistently on server
  First visit stores code
  Further visits exploit issue
Lazy XSS
  Multi-stage
  inject now, attack later


Same origin policy
* Isolates applications running in browser
* (domain, port, protocol) has to equate

Mitigation
- input sanitization
- use existing frameworks
- blacklisting / whitelisting
- Google Chrome has XSS filter
- Firefox NoScript plugin

Integer overflow
----------------

* Memory safety violation
* Affecting integrity, availability and confidentiality
* addition, subtraction, multiplication, division, modulo
* Signed integer, two's complement

Potential
* Attacking resource allocation
* Attacking program control
* Security problems (eg. Certificate validations)
* Taking over attacked process
* Taking over attacked computer

Certificate validation - Object ID
* Certificates bind cryptographic keys to subject names
* Common name / subject name might overflow

Mitigation
* Code review
* Analysis tools
* Safe integer libraries

Buffer overflow
---------------

* Problems with automatic variables in C, functions in C, stack
* Buffers are chunks of memory (continuous and of homgeneous type)
* Non-memory-safe programming language: no automatic boundary checks!
* Attack vectors
    * Data controls control flow (critical variables, function pointers)
    * Change data using buffer overflow
    * system("/bin/sh");

Anatomy:
1. Overflow phase (violate boundary)
   Defense: Write secure code, code review, analysis tools
   (Splint, RATS, ITS4, PREfast, flawfinder)
   Detection: change stack layout, separate stacks
2. Activation phase (normal operation, but malicious code was already written)
   Use canary: guard values by compiler, placement, checked on function return
3. Seized phase (left normal execution path, executing attack code)
   Defense: Execution protection of data pages

Problematic C functions:
* char *strcpy(char *dest, const char *src);
  char *strncpy(char *dest, const char *src, size_t n);
* char *strcat(char *dest, const char *src);
  char *strncat(char *dest, const char *src, size_t n);
* int snprintf(char *str, size_t size, const char *format, ...);
  int sprintf(char *str, const char *format, ...);
* int scanf(const char *format, ...);

void foo(const char *input) {
  char buf[4];
  strncpy(buf, input, 4);
  buf[3] = "\0";
}

C and memory layout of variables:
* Initializing memory
    1. Create process (virtual memory)
    2. Load executable file (file sections to virtual memory)
    3. Link new executable (shared libraries)
    4. Execute code
* virtual memory usage (linear addressing, paging)
    * stack (functions, local variables; grows against 0)
    * heap (dynamically allocated variables)
    * BSS (uninitialized vars)
    * data segment (initialized vars)
    * text segment (code)
* registers
    * eax, ebx, ecx, edx, esi/edi
    * ccr (conditional code register; status flags {overflow,carry,zero})
    * eip/pc (instruction pointer)

cdecl calling convention
1. Push parameters right to left
2. Call function, push eip
3. Update ebp (push ebp, update ebp to esp)
4. Allocate automatic variables (decrement esp)
5. Execute function (ebp points to automatic variables)
6. Clean up automatic variables (restore ebp)
7. Restore ebp (pop ebp)
8. Return (pop eip)
9. Clean up arguments (increment esp)

Shell code
* shellcode is a small piece of code used as the payload
  in the exploitation of a software vulnerability

Heap
* Managed by linked list

Mitigation:
* Address space layout randomization (but entropy often low)
* Non-executable stack pages

Forms of attacks:
* Stack smashing attacks (eg. format string vulnerabilities)
  * Return to libc attack (code execution without injection, modify stack)
    * Return-oriented programming (circumvents W⊕R, chaining short gadgets)

Format String Vulnerabilities
-----------------------------

* Arbitrary data writes (integrity, availability)
* Arbitrary data reads (confidentiality)
* Family of printf and scanf functions
* Variadic functions - indefinite arity
* Defense by code review and static code analysis

* Do not let the user specify a format string
* Sanitize format string

Cryptography and cryptographic primitives
-----------------------------------------

{DES, 3DES, RC4, AES, SHA2, SHA3}

Kerckhoffs' Principles:
* The system must be practically, if not mathematically, indecipherable
* It must not be required to be secret, and it must be able to fall
  into the hands of the enemy without inconvenience
* Its key must be communicable and retainable without the help of
  written notes, and changeable or modifiable at the will of the
  correspondents
* It must be applicable to telegraphic correspondence
* It must be portable, and its usage and function must not
  require the concourse of several people
* Finally, it is necessary, given the circumstances that
  command its application, that the system be asy to use,
  requiring neither mental strain nor the knowledge of
  a long series of rules to observe

* Hash function provide message integrity
* Message authentication codes (symmetric, message integrity, origin integrity)
* Signature schemes (asymmetric, message integrity, origin integrity)

Cryptographic Nonces
* Arbitrary pseudo-number used only ONCE
* Motivation: {Eavesdropper, Replay attacks}
* Supports information freshness

Symmetric ciphers
* Participants share the same key
* Confidentiality, authenticity, fast, difficult key distribution
    (n * (n-1)) / 2 keys
* One-Time Pad provides perfect secrecy: key XOR message
  key length = msg length, use only once
* Block ciphers split message into same-sized blocks and encrypts them separately

Modes of operations (symmetric ciphers)
* Electronic Codebook Mode (ECB, do not use)
* Cipher Block Chaining Mode (CBC)
    encryption:   Cᵢ = Eₖ (Pᵢ ⊕ Cᵢ₋₁), C₀ = IV
    decryption:   Pᵢ = Dₖ (Cᵢ) ⊕ Cᵢ₋₁, C₀ = IV
* Cipher Feedback Mode (CFB)
    encryption:   Cᵢ = Pᵢ ⊕ Eₖ (Cᵢ₋₁), C₋₁ = IV
    decryption:   Pᵢ = Cᵢ ⊕ Eₖ (Cᵢ₋₁), C₋₁ = IV
    no padding, sequential encryption, parallel decryption,
    resilient against bit flips, self synchronizing
* Output Feedback Mode (OFB)
    encryption:   Cᵢ = Mᵢ ⊕ Sᵢ, S₁ = Eₖ(Sᵢ₋₁)
    decryption:   Mᵢ = Cᵢ ⊕ Mᵢ
    no padding, sequential key stream generation, synchronous,
    highly resistent against bit flips
* Counter Mode (CM)

Data Encryption Standard
* Developed in 1976
* 64 bit keys, 8 bit checksum, 56 bit key space, 64 bit block size
* Brute-force (1999): 22 hours

Triple-DES
* C=Eᴋ₁(Dᴋ₂(Eᴋ₁(M)))     [EDE2, 112 bit key space]
* C=Eᴋ₁(Dᴋ₂(Eᴋ₃(M)))     [EDE3, 168 bit key space]

Meet-in-the-middle attack

AES (Rijndael, 2000)
* DES not secure, 3DES is slow
* 128, 192 or 256 bit key size, 128 bit blocksize

Stream ciphers
* Cᵢ = Mᵢ ⊕ Kᵢ, Pᵢ = Cᵢ ⊕ Kᵢ
* {bitwise, fast, simple, secure}
* Never reuse keystream
* {RC4, GRAIN, HC-128, HC-256, Blockciphers}

Cryptographic hash functions
* {Preimage resistence, collision resistance, second preimage resistance}
* Attack with birthday attack or length extension attack
* Don't use MD*. Prefer SHA-1 (compatibility) or better SHA-256
* Merkle-Damgård design

Message Authentication Code
* Are based on hash functions and block ciphers
* HMAC

Asymmetric cryptography
-----------------------

Hard mathematical problem:
* Integer factorization
* Discrete logarithm problem

Cryptography system:
* RSA algorithm
* Elliptic Curve Cryptography
* ElGamal

Standards:
* PCKS#1 (RSA)
* ECDSA (ECC)
* DSA (ElGamal)

Encryption: C = Eₖₑ(M)
Decryption: M = Dₖₑ(C)
Signature: S = Signₖₛ(H(M))
Verification: R = Verifyₖᵥ(M,S)

Encryption
* Confidentiality

Signature
* Data integrity
* Origin integrity
* Non-repudiation

RSA algorithm
* c = mᵉ mod n
* m = cᵈ mod n
* d = (e⁻¹) mod phi(n)   private exponent
* e                      public exponent

TODO

Key management
--------------

* Key must be correctly used and protected
* Key might be stolen, destroyed and misused
* Symmetric keys {shared secret keys, n*(n-1)/2 keys, confidentiality, integrity}
* Asymmetric keys {shared public keys, n keys, confidentiality, integrity}
* RFC 5280 X.509 profile  defines
    * Certificate format {public key certificate, attribute certificate}
    * Revocation list format {X.509 certificate status}
    * Certificate paths {Construction, Validation}

Usage recommendations
* Usage separation (because {key compromise, key lifetime requirements,
  cryptosystem pecularities})
* Tokens {Smart card, Hardware Security Module, USB token, Trusted Platform Module}
  On-token key life cycle
  Token never leaves token
  (optional) Hardware protection
* Key renewal: ciphertext amount, key search time, key compromise

Public Key Infrastructure:
* Ensure origin integrity
* Third party confirms identities
* Certificate Authority certifies identities
* Provides infrastructure to retrieve certificate status information
* Recommendation: Short validity
* Problems:
    * Naming / Unique names
    * Directory problem
    * CRL: Blacklisting approach, issuing frequency, DOS vulnerability
    * CRL: cost, no historic information, revoking root CA?
    * OCSP: Practical CRL problem mitigation, Ambiguous status
    * OCSP: Increased server load
    * "The spaghetti of doubt"

Issuing a certificate
* Verify identity of applicant
* Verify exclusive key control of applicant
* Sign applicant's certificate

Certificate validation
* Check certificate signature

Obtain key
* Face to face
* Software deployment
* Telephone

Cross certification
  Signatures exist in both directions (CA–Enduser, Enduser–CA)

X509 certificates
* Issuer           }  unique certificate
* Serial number    }    identification
* Validity
* Subject
* Subject public key
* Issuer signature
* Extensions
    * Basic constraints     }     key
    * Key usage             }    usage
    * Extended key usage    }  restrictions
    * Certificate policies
    * Name constraints
    * Logotype extension   (useful for collision attacks)
    * CRL distribution points         }  certificate
    * Authority information access    }  revocation

Checking a certificate
* Verify signature using the public key
* Certificate issuer equals issuer
* key = certificate public key
* issuer = certificate subject
* Check validity for current timestamp
* Check revocation status with
    * CRL: Certificate revocation list
    * OCSP: Online Certificate Status Protocol
* Check constraints
    * If intermediate certificate
        * Basic Constraint: CA
        * Basic Constraint: Path length is appropriate?
        * Key Usage: keyCertSign
    * Process critical extensions

Date validation
* PKIX: time of validation
* Modified PKIX: time of signing
* Chaining model: time of issuing a subcertificate

Reasons for certificate revocation (= premature certificate invalidation):
* Change of name
* Change of association (entity ↔ CA)
* Key compromise

CRL
* nextUpdate field specifies update period
* Delta CRLs: contain differences to reference CRL (reduces size)
* Indirect CRLs: revocation information from other CAs
* Request = {issuer name, serial number}

OCSP
* {Revoked, Unknown, Good}
* Good != Valid

CRL vs OSCP
* Complexity: high  vs  average
* Size: (proportional to number of revoked certificates)  vs  constant
* Timeliness: determined by issuing interval  vs  depends on implementation
* Historic information: no  vs  optional

Data encoding
-------------

* Different platforms, different byte orders, different programming runtimes
* Different data types, different data layouts
* ASN.1 and base64 (3 bytes to 4 bytes)

Abstract Syntax Notation 1 (ASN.1)
* Transfer format
* Basic Encoding Rules (BER) and Distinguished Encoding Rules (subset, DER)
* Data types = {BOOLEAN, INTEGER, BIT STRING, OBJECT IDENTIFIER, …}
* Sequences = {SEQUENCE(OF <TYPE>), SET(OF <TYPE>), CHOICE, …}
* Optional values are encoded in TLV (type, length, value)