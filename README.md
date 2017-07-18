What this module does

- Create a new content type (bc_api_media_list)
- The new content type accepts and advanced search string from BiblioCore advanced search page (https://mymcpl.bibliocommons.com/search )
- Other content types can use node reference fields to render (via template customizations) the returned results.
- Note: The module doesn't create any nodes. It renders output on the fly with php + an API call. 

Setup

- Make a copy of default.config.php and rename it to config.php.inc
- Edit BC_API_PRIVATE_KEY and BC_API_LIBRARY parameters with the values provided to you by BiblioCommons
- Install the module via the usual method


TO DO
- Replace node body field with a standard text field in the created content type.
- Check for valid cover art
- Use Other API methods (Title, subject, series, author search, etc.)
- Move functional code out of the template file
