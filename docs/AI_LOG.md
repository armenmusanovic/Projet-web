# AI Log

## Milestone 1

### AI tools used
I used AI models (Claude and others) in some parts of the project.
- I wrote the frontend (HTML and CSS) myself.
- I sent my frontend to AI models to fix and improve it.
- AI helped me most with JavaScript, because it is my weakest part.
- Claude also helped me with Git, GitHub and the folder structure.

### Most important prompts
1. "How do I create a GitHub repository for Milestone 1 and connect it with VS Code?"
2. "Fix and improve my JavaScript code."
3. "Is this a good folder structure and how do I test the site?"

### Cases where AI was wrong
1. **Problem:** AI gave me the command `echo. > .gitignore`. It does not work in PowerShell.
   **How I noticed:** PowerShell showed an error "term not recognized".
   **Fix:** I used `Set-Content .gitignore` instead.

2. **Problem:** The first AGENTS.md from AI was too short. It had no folder structure and no naming rules.
   **How I noticed:** I checked the project requirements and saw that parts were missing.
   **Fix:** I extended it and wrote my real project details.



## Milestone 2

### AI tools used
- Chat gpt and others: helped me design the database schema from my ERD, write `database.sql`, and write the DAO layer (`Database`, `BaseDao` and six DAO classes) and a test script.
- I tested everything myself in phpMyAdmin and in the browser (`backend/test_dao.php`).

### Most important prompts
1. "Milestone 2: create the database with at least 5 entities and the DAO layer with a BaseDao."
2. "Explain what this INSERT code in the SQL file means."
3. "Is the RequestDao file correct? It has the same size as UserDao."

### Cases where AI was wrong or gave poor results
1. **Problem:** The AI told me to paste the SQL into `database.sql`, but I created the file and the import said "0 queries executed". The file was empty because I did not paste and save the code. Later the import also failed because a comment and an INSERT were joined into one line.
   **How I noticed:** phpMyAdmin showed "0 queries executed", then a syntax error (#1064).
   **Fix:** I pasted the full SQL, put every statement in its own line, saved with Ctrl + S and imported again. 20 queries ran and all sample data was inserted.

2. **Problem:** The AI wrongly suspected that `RequestDao.php` had the wrong content because its file size was the same as `UserDao.php`.
   **How I noticed:** I checked the file with `Get-Content` and it was correct. Same size was only a coincidence.
   **Fix:** No change needed. I learned to check the content, not guess from the size.

