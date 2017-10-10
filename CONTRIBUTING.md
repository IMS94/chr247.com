# Contributing to chr247.com

chr247.com welcomes contribution from everyone. Here are the guidelines if you are
thinking of helping us:

## Contributions

Contributions to chr247.com or its dependencies should be made in the form of GitHub
pull requests. Each pull request will be reviewed by a core contributor
(someone with permission to land patches) and either landed in the main tree or
given feedback for changes that would be required. All contributions should
follow this format, even those from core contributors.

Should you wish to work on an issue, please claim it first by commenting on
the GitHub issue that you want to work on it. This is to prevent duplicated
efforts from contributors on the same issue.

## Making Code Contributions

### 1. Fork the project on Github
* Navigate to the [chr247.com repo on github](https://github.com/chr24x7/chr247.com)
* In the top-right corner of the page, click Fork. 

### 2. Check out your copy locally
```
git clone git@github.com:<your-username>/chr247.com.git
cd chr247.com
```

### 3. Add remote
```
git remote add upstream https://github.com/chr24x7/chr247.com.git
```

### 4. Create a feature branch
Before starting to make changes, you should create a branch for them:
```
git checkout -b add_feature_x
```

### 5. Make your changes
Now you can start modifying, addin or removing files, try to create commits regularily,
and avoid mixing up changes on the same commit.

To commit the changes:
```
git add <modified_file>
git rm <file_to_delete>
git add <any_new_file>
git commit
```
To write a good commit message:
* Describe why you did the change, not what the change is (the diff already shows the what).
* In the message body, add as many information as you need, it’s better to be extra verbose than the alternative.
* If it adresses an issue, add the coment closes #1234 to the description, where #1234 is the issue number on github.

### 6. Rebase to keep updated
To sync your work from time to time and avoid conflicts it is a good idea to rebase.
To do so:
a. Fetch changes from the remotes:
```
git fetch --all
```
b. Rebase your code and edit, drop, squash, cherry-pick and/or reword commits. 
This step will force you to resolve any conflicts that might arise.
```
git rebase -i master
```

### 7. Push your changes
```
git push origin add-feature-x
```

### 8. Make a pull request
Go to https://github.com/yourusername/chr247.com and select your feature branch.
Click the 'Pull Request' button and fill out the form.

## Report Issues

If you find a bug/issue and want to report it, open a [new issue](https://github.com/chr24x7/chr247.com/issues/new)
and be sure to include a title and clear description, as much relevant information
as possible, and a code sample or a test case demonstrating the expected behavior
that is not occurring.

Discussions can be done via github issues.
