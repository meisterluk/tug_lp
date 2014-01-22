Digital Libraries
=================

:title:      Digital Libraries, lecture notes
:lecturer:   Berndt René
:date:       Jan 2014

Libraries
---------

Libraries act as mediators between information and users. They play an
important role in information retrieval and knowledge transfer.

Properties and problems:
∙ Libraries are the managed interface between information and user.
∙ “The primary role of a digital library is solving the problems of
  conventional libraries”
∙ Funding:
  Private funding models exist, but many libraries are financed by
  the public as part of national information infrastructure programs.
∙ Traditionally, information is stored in paper form (books, journals,
  etc.) and libraries have long experience in working with paper documents
∙ Aspects to handle with:
  ∙ Selection: Definition of collections
  ∙ Acquisition: Physical objects
  ∙ Description: Catalogs
  ∙ Access: Shelves
  ∙ Preservation: Controlled environment
∙ Digitization implications for role of libraries:
  ∙ Economic: Electronic access (who pays? restrict access?)
  ∙ Digitization
    ∙ How to organize the digitization process?
    ∙ Quality standards?
  ∙ Indexing: How to automatically index and search in digital documents?
  ∙ Long term preservation: 
    ∙ How to provide accessibility? How to securely store data?
  ∙ Multimedia and non-textual documents
∙ Why did paper libraries not disappear?
  ∙ Costs (Google: 1 tri. dollar for digitizing 100 Mio. books excl. copyright fees)
  ∙ User access (preference of paper books, bad UIs)
∙ Even the largest national libraries are doubling in size every 16-20 years
∙ Search in non-textual documents, content-based indexing, visualization
∙ Doomesday-Project:
  ∙ British students are asked to describe local information for long-term archival
  ∙ More than 1 Mio. participants
  ∙ Failed: Choice of wrong medium, laserdisc got obsolete, copyright issues
∙ Long-term archival
  ∙ Degradiation (Paper decay (eg. dt. Säurefraß), fire, humidity, flammable nitrofilm)
  ∙ Burning of library of Alexandria, Collapse of Kölner Stadtarchiv (2009)
  ∙ Media get deprecated and need to be updated

XML technologies
----------------

URI ⊃ {URN ∩ URL}
URI = scheme ":" hier-part ["?" query] ["#" fragment]
URN = eg. "urn:isbn:012857213"
URL = also defined Location/Access-method (http/ftp/…)

∙ Subset of SGML (ISO 8879:1986, Standard Generalized Markup Language)
∙ XML has much simpler syntax
∙ XML vs SGML: http://www.w3.org/TR/NOTE-sgml-xml-971215.html

XML as abstraction layer:
∙ Sectors, Bitstream: hardware specific
∙ Files, Packages: OS/protocol specific
∙ Entities, Documents: XML 1.0
∙ Elements, Attributes: XML 1.0 + XML Namespaces
∙ Types, instances: XML schema
∙ Classes, objects: Application-specific

Versions:
1.0, fifth edition
  Between 10th February 1998 and 26th November 2008
  http://www.w3.org/TR/1998/REC-xml-19980210
  http://www.w3.org/TR/xml/
  ∙ prefer this version!
1.1, second edition
  Between 13th of December 2001 and 16th of August 2006
  http://www.w3.org/TR/2001/WD-xml11-20011213/
  http://www.w3.org/TR/xml11/
  ∙ Native Mongolian, Yi, Cambodian, Amharic, Dhivehi, Burmese support
  ∙ It expands the set of characters allowed as name characters
  ∙ The C0 control characters (except for NUL) such as form feed, vertical tab,
    BEL, and DC1 through DC4 are now allowed in XML text provided they are
    escaped as character references.
  ∙ C1 control characters (except for NEL) must now be escaped as
    character references
  ∙ NEL can be used in XML documents, but is resolved to a line feed on parsing.
  ∙ Parsers may (but do not have to) tell client applications that
    Unicode data was not normalized
  ∙ Namespace prefixes can be undeclared

XML design
~~~~~~~~~~

Elements vs attributes:
  <rect><point>0,0</point><point>3,4</point></rect>
  <rect point1="0,0" point2="3,4" />

  ∙ Element: If information could be itself marked up
  ∙ Element: Multiple attributes with the same name
  ∙ Attribute: Standardization required (DTD-like - ID,IDREF,ENTITY)
  ∙ Element: No whitespace normalization

Well-formed XML:
∙ XML declaration at beginning
∙ Unique root element
∙ Start tags must have matching end tags
∙ Case sensitive elements
∙ All elements must be closed (or declared as EMPTY)
∙ Proper nesting
∙ Attribute values must be quoted
∙ Use entities for special characters

Document Type Definition (DTD, prefer XML Schema today)
  <?xml version="1.0" encoding="utf-8" ?>
  <!DOCTYPE rootelement [
    <!-- order list of subchildren; also defines quantity -->
    <!ELEMENT child (subchild1,subchild2,subchild3)>
    <!-- EMPTY for empty elements, ANY for elements w/o content restrictions -->
    <!ELEMENT subchild1 (EMPTY)>
    <!-- PCDATA or (unparsed) CDATA and(!) any of the given elements -->
    <!ELEMENT subchild2 ((#PCDATA|#CDATA),details)>
    <!-- Quantifiers: ? + * -->
    <!ELEMENT subchild3 (#PCDATA|summary)*>
  ]>
  <!ATTLIST child
    attr    CDATA          #REQUIRED
    id      ID             #IMPLIED
    valid   CDATA          #FIXED "true"
    allow   (yes | no)     "yes"
  >
  <subchild2>
  <![CDATA[
    python.runtime.print("Hello World");
  ]]>
  </subchild>

  Attribute types:
    CDATA, (enum|values|...), ID, IDREF, IDREFS, NMTOKEN, NMTOKENS
    ENTITY, ENTITIES, NOTATION, xml:
  Attribute default values:
    value, #REQUIRED, #IMPLIED, #FIXED value

XML Schema:
∙ Defines elements and attributes and their data types
∙ Defines parent/child relation between elements
∙ Defines order and number of children
∙ Element is empty or contains text
∙ Defines default and fixed values for elements and attributes

Simple types
  contains only text, no elements and attributes
  xsd:string, xsd:decimal, xsd:float, xsd:boolean, xsd:date, xsd:time
  or list and unions of these types
  restriction spec: enumeration, fractionDigits, length, minLength, maxLength,
    {min,max}Exclusive, {min,max}Inclusive, pattern, totalDigits, whiteSpace
Complex types
  contains other elements and/or attributes or empty elements
  xsd:sequence, xsd:choice, xsd:all (unordered)

XSLT (Extensible Stylesheet Language for Transformations)
∙ CSS cannot change order of elements, CSS no calc, CSS cannot combine documents
∙ application example:  XHTML → (with) XSLT → XSL-FO → (with) FO processor → PDF
                        http://xmlgraphics.apache.org/fop/
∙ Implementation of processors by Saxon, Xalan, …
∙ <xsl:if test="count(…) &gt; 10">…</xsl:if>
∙ <xsl:choose><xsl:when test="condition">…</xsl:when>…</xsl:choose>
∙ <xsl:for-each select="selector">…</xsl:for-each>
∙ <xsl:apply-templates …> <xsl:template …>

XPath
∙ "/" is root, "." is current element, ".." is one level up
∙ "element" selects all tags "element"
∙ "parent/child" selects all tags "child" with parent "parent"
∙ "/parent/child" selects all tags "child" with parent "parent" which is root
∙ "./@lang" attribute "lang" of current element
∙ "comment()", "text()", "processing-instruction()"
∙ Aliases: parent == ..    self == .    attribute == @attribute
  eg.  attribute::lang == @lang
∙ Boolean operations by keywords: "and", "or"
∙ Predicates: "parent/child[2]"  or union  "parent/child[2|5]"
  "element[last()]", "element[position() mod 2 = 0]", "count(selector)"

RDF
~~~

∙ {Subject, predicate, object}

Information processing fundamentals
-----------------------------------

Information is a sequence of symbols that can be interpreted as a message.
Different message can share the same "interpretion".

Knowledge is a set of models, objects and other facts held by individuals
or humanity as a whole at a certain times, to which they have access and
which is held to be true. Knowledge can be active/passive and implicit/explicit.

∙ Fundamental knowledge
∙ Knowledge of means
∙ Knowledge of tools

A digital document is an enclosed information unit, recorded in a digital
manner that requires a computer or other electronic device to display,
interpret and process it.

Why digital?
∙ Storage capacity, transfer rate, multiple uses
∙ selective information distribution, worldwide availability
∙ processability, content-based indexing, integrated visualization
∙ easy to change (but plagiarism and citability as problem)

Convential libraries
∙ Building with collections of books, art, video, audio, …
∙ Types
  ∙ Municipal library
  ∙ University library
  ∙ Company libraries
  ∙ National library
∙ Five laws for library science (Ranganathan, 1931)
  ∙ books are for use
  ∙ every reader his book
  ∙ every book its reader
  ∙ save the time of the reader
  ∙ a library is a growing organism
∙ Alexandrian principle: It's a librarian's duty to increase the stock of his library
∙ Problems
  ∙ Storage space, insufficient space for readers, damage
  ∙ Cost difference between acquisition and budget
  ∙ Conflict between wide-ranging and actual need
  ∙ Time-consuming acquisition and description
  ∙ External borrowing

Electronic library
  text, images, animations, audio, video stored on electronic datacarriers
Virtual library
  large variety of library service as a translocal alliance

Service and data are integrated and allow efficient access using
a uniform system interface.

"Digital libraries are a set of electronic resources and associated
technical capabilities for creating, searching and using information…
they are an extension and enhancements of information storage and
retrieval systems that manipulate digital data in any medium (text,
sounds, static or dynamic images)"

Common elements in definitions:
∙ DLs are not a single entity
∙ DLs require technologies to link resources to many
∙ Linkages between many DLs and information services are transparent to user
∙ Universal access to DL and information services is a goal
∙ Digital library collections are not limited to document surrogates

∙ Library professionals emphasize digital libraries as services
∙ Computer scientists emphasize the enabling technologies

Important properties of a digital library:
∙ Site Neutrality (Access anytime, anywhere, anyone)
∙ Enables OpenAccess and information sharing
∙ Greater variety and granularity of information
∙ Up2date-ness
∙ Integration of digital media into traditional collections
∙ DLs support creation, maintenance, management, access and preservation of content

Examples:
∙ europeana
∙ Deutsche Digitale Bibliothek
∙ wdl.org

Metadata
--------

http://dlib.indiana.edu/~jenlrile/metadatamap/

DELOS Network of Excellence on Digital Libraries:
"The DELOS vision for digital libraries is that they should enable any citizen to access all human knowledge any time and anywhere, in a friendly, multi-modal, efficient and effective way, by overcoming barriers of distance, language, and culture and by using multiple Internet-connected devices"

∙ Digital library (DL)
  organisation (possibly virtual) to collect, manage and preserve
  rich long-term digital content
∙ Digital library system (DLS)
  Software system based on a defined (possibly distributed) architecture
  providing all functionality required by a particular DL
∙ Digital library management system (DLMS)
  Generic software system that provides appropriate software infrastructure to
  ∙ produce/administer a DL
  ∙ integrate additional software offering refined, specialised functionality

Types of DLMS:
∙ Extensible digital library system
∙ Digital library system warehouse
∙ Digital library system generator

Cataloguing
~~~~~~~~~~~

Card catalog
  Author, title, physical description {# pages, has illustrations, height},
  imprint {place of publication, publisher, date of publication}, subject
  access points

Online Public Access Catalogue (OPAC standard)
∙ Author
∙ Title
∙ Corporate body
∙ ISBN
∙ Publisher
∙ Year of release

Types:
∙ Shelf catalogue
∙ Alphabetical order:
  ∙ ISBD
  ∙ AACR (Anglo-american Cataloguing Rules)
  ∙ RAK
∙ Classified catalogue
∙ Subject heading catalogue

More up2date: Resource Description and Access (AACR3/RDA standard)

Classification
~~~~~~~~~~~~~~

Dewey Decimal Classification (DDC)
∙ 10*10*10 (sub)categories
∙ Main classes:
  ∙ Informatik & Informationswissenschaft & allg. Werke
  ∙ Philosophie & Psychologie
  ∙ Religion
  ∙ …

Library of Congress Classification (LCC)
∙ eg. ZA080.E535 2000
∙ {broad topic, sub topic, subclass} {cutter number} {publication date}

Cutter number
∙ Algorithm for sorting the holding of books
∙ Starting character of authors + 2-3 digits

ACM classification:
∙ http://www.acm.org/about/class

Metadata
~~~~~~~~

"Data about data"

Type of Metadata
∙ Administrative (eg. copyright)
∙ Descriptive (eg. title, author)
∙ Preservation (information about preservation of medium)
∙ Technical (data format)
∙ Usage (usage count)

MARC standard
∙ machine-readable cataloging
∙ based on AACR2R
∙ binary format, MARCXML as XML format
∙ MARC21
  ∙ USMARC + CAN/MARC
  ∙ Unicode support

Further standards for bibliographic metadata:
∙ BibTeX
∙ EndNote
∙ Dublin Core Metadata Initiative
  ∙ 15 core elements for the Web (contributor, coverage, date, creator, language, …)
  ∙ also for XML/RDF

Metadata Encoding and Transmission Standard (METS)
∙ MARC for library catalogues
∙ XML
∙ Supports descriptive, structural and administrative metadata
∙ Dublin Core describes resource as a whole
  META structural map addresses part within the resource

CIDOC-CRM
---------

Extensible ontology for concepts and information in cultural heritage and
museum documentation (developed by CIDOC Documentation Standards Group).

An ontology is a formal, explicit specification of a shared conceptualisation.

Goals:
∙ Enable information exchange and integration between heterogeneous sources
  of cultural heritage information
∙ Enables semantic interoperability
∙ Does NOT claim which institutations shall be documented

Properties:
∙ Ontology of 86 classes and 137 properties.
∙ Multiple inheritance, multiple instantiation, multiple isA-relations, Joins
∙ Classes: eg. {Thing, Place, Person, Dimension, Information Carrier, …}
∙ Properties: eg. {has created, was measured by, is carried by, was modified by}

∙ Allows semantic interoperability
∙ More expressive and extensible than typical metadata standards
∙ Intellectual guide to create schemata, formats and profiles

Coreference
  Reference in one expression to the same referent in another expression.

Interchange protocols
~~~~~~~~~~~~~~~~~~~~~

∙ Z39.50: Client-server protocol at OSI application layer
∙ Z39.50 CCL: Common Command Language (search engine commands, eg. WYR=year of pub)
∙ Z39.50 DBV-OSI: Open Systems Interconnection - Information exchange, german DLs
∙ Contextual Query Language (CQL): Queries for information retrieval systems

OAI
~~~

OAI-PHM:
∙ OAI Protocol for Metadata Harvesting
∙ REST + XML
∙ Dublin Core, MARC, MARCXML
∙ Requests: {Identify, ListSets, ListIdentifiers, ListMetadataFormats, …}
∙ verb, metadataPrefix, resumptionToken

Documents
---------

"A text file is given, iff the human eye can identify, read and interpret text"

∙ Computers can manipulate {text, images}
∙ ASCII 7-bit, EBCDIC (extended binary coded decimal for interchange code), ISO/IEC 646
∙ Universal Character Set (UCS)
  ISO 10646-4:2008
∙ UTF-32, UTF-8

Scanning:
∙ Mass digitization systems
∙ Resolution of 118 dots/centimeter (300 dpi) is adequate
∙ Optical Character Recognition
∙ Separation of structure and appearance
∙ Border removal, Page curl fixing
∙ Improving access by OCR technology, removing language barriers, ensure interop

IMPACT project
  http://www.impact-project.eu/
Gutenberg project (free ebooks)
  http://www.gutenberg.org/

Text documents
∙ HTML + CSS

Page Description Languages
∙ TeX
∙ PostScript
∙ PDF
∙ ODF: {Physical Layer, XML Layer, Convenient Functionality Layer, Extendable Layer}
∙ OOXML (Office Open XML by Microsoft)

Images: {PNG, JPEG, TIFF, GIF, SVG}
Audio: {PCM, WAV, MP3, AAC, FLAC}
Video: {MPEG, AVI, ASF, QuickTime, FLV, H.264, WebM}
Multimedia formats: {VRML, X3D, OBJ, 3DS, Collada, …}

Search & Retrieval
------------------

Methods
∙ Linear Searching
  ∙ Boyer-Moore algorithm
∙ Inverted Files (cannot search for arbitrary strings)
∙ Hash Tables (difficulty to select appropriate hash function)

Language Processing: phonetic search

Content-based search
∙ Similarity search for images (Tamura Texture Image Features)
∙ {supervised, unsupervised} feature selection methods
∙ distance measures

Service-oriented architecture (SOA)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

1. Boundaries are explicit
2. Services are autonomous
3. Services share schema and contract, not class
4. Service compatibility is based on policy

Technologies: {RPC, DCOM, CORBA, SOAP/REST}

"Web service is a software system designed to support
interoperable machine-to-machine interaction over a network"

∙ Web Service Description Language (WSDL) for SOAP
∙ SOAP-MTOM (SOAP for large binary data)
∙ MTOM/XOP

Web service technologies:
http://www.innoq.com/de/ws-standards-poster/innoQ%20WS-Standards%20Poster%202007-02.pdf

REST design principles:
∙ Use HTTP methods explicitly ({GET, POST, PUT, DELETE, HEAD, OPTIONS})
∙ Be stateless
∙ Expose directory structure-like URIs
∙ Transfer XML, JSON or both

Web Application Description Language (WADL)
∙ XML-based
∙ machine processable description of HTTP-based web applications

Long-term archival
------------------

Developing strategies to preserve digital resources
(even on an ever-changing information market)

∙ General agreement that cultural heritage shall be preserved
∙ Availability and access
∙ Legal frameworks
∙ Financing
∙ Responsibilities and competences
∙ Selection criteria
∙ Security

LAM = {Libraries, Archives, Museums}

ArchiSafe
  http://www.archisafe.de/s/archisafe/index

Bit Preservation:
∙ (Semi)automatic control mechanism for monitoring the internal data transfer
∙ Logical preservation is more difficult than structural preservation
  Logical preservation
    the ability to reconstruct streams of bits in a meaningful way that computers and humans can interpret, use, repurpose, and understand at any arbitrary point in the future.
  Structural preservation
∙ Achieved by {redundancy, heterogenity of media,
  appliance to long-term standards, periodical migration of media}
∙ Emulation vs Migration
∙ Which format to take? Openess, well-known, complexity, protection against
  invalidity, self-documenting, robustness, dependencies

OAIS
~~~~

∙ is a reference model, not implementation guide
∙ OAIS model between producer and consumer
∙ Functional model
  ∙ Ingest
  ∙ Archival storage
  ∙ Data management
  ∙ System management
  ∙ Preservation planning
  ∙ Access

PLANETS project
  http://www.planets-project.eu/
FACADE project
  http://facade.mit.edu/

Building Information Modeling (BIM)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Describes a method of optimized planning, application and cultivation of buildings
with the help of software.

DURRARK project
  Durable Architectural Knowledge
  building a secure and efficient long-term preservation solution for 3D architectural data
