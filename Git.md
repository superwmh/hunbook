# git branching model #

![http://commondatastorage.googleapis.com/0000/muchiii/git-flow-20111215.png](http://commondatastorage.googleapis.com/0000/muchiii/git-flow-20111215.png)

# .git/config #

```
[core]
	autocrlf = input  # force convert crlf to lf
[user]
	name = HunterLaptop
	email = hunter.wu@gmail.com
```

# clone #

```
# error: SSL certificate problem, verify that the CA cert is OK.
$ export GIT_SSL_NO_VERIFY=true 
```


# commit #

```
git commit -am "Upload all modified files"
```

```
git add file1
git add file2
git commit -m "Upload added files only"
```

# branch #

```
# list branch
git branch

# create branch
git branch staging430

# switch branch
git checkout staging430

# reset to a specifed commmit
git reset 07eeb38562957ea1e486bfa8ace343d94e66d57b
git checkout -f 

# merge
git merge testing

# delete
git branch -d testing

# undoing merge
git reset --hard ORIG_HEAD

# undoing commits
git reset 7654321
git checkout -f
git reset origin master
git push

# create
git push origin master:refs/heads/the_branch_name
git fetch origin
git branch --track the_branch_name origin/the_branch_name
git checkout the_branch_name

# track
git fetch origin
git branch --set-upstream the_branch_name origin/the_branch_name
git checkout the_branch_name

# delete
git push origin :refs/heads/20111030_space_urlencode
git branch -d 20111030_space_urlencode

# prune
git remote prune origin
```

# patch #

```
#http://www.cloudspace.com/blog/2010/07/14/patching-with-git-format-patch-and-git-am/

git format-patch -1 953b9be

git am -s 0001-my-fix.patch
```

# diff #

```
git diff yourfile
```

# ignore file #

  * .git/info/exclude
  * .git/config - core.excludesfile
  * .gitignore

# tag #

```
# 建立簡短的縮寫
git tag v20100930 61755a574a29175283b118ea2d3d39bc2852f449

# 刪除
git tag -d v20100930

# 另一種建立 tag 的方式
git tag -a v20100930 -m "Alpha launch"

# push all tags
git push --tags
```

# remote #
```
git remote add augmentum w3.aug.com:lib.git
git push augmentum master
```

```
# 改 origin
git remote set-url origin git@dev.example.com:hunbook.git
```

# log #

```
git log --pretty=oneline
git log --pretty=format:"%ai %h %an, %s"
```

  * %H: commit hash
  * %h: abbreviated commit hash
  * %T: tree hash
  * %t: abbreviated tree hash
  * %P: parent hashes
  * %p: abbreviated parent hashes
  * %an: author name
  * %aN: author name
  * %ae: author email
  * %aE: author email
  * %ad: author date (format respects --date= option)
  * %aD: author date, RFC2822 style
  * %ar: author date, relative
  * %at: author date, UNIX timestamp
  * %ai: author date, ISO 8601 format
  * %cn: committer name
  * %cN: committer name
  * %ce: committer email
  * %cE: committer email
  * %cd: committer date
  * %cD: committer date, RFC2822 style
  * %cr: committer date, relative
  * %ct: committer date, UNIX timestamp
  * %ci: committer date, ISO 8601 format
  * %d: ref names
  * %e: encoding
  * %s: subject
  * %f: sanitized subject line, suitable for a filename
  * %b: body
  * %B: raw body (unwrapped subject and body)
  * %N: commit notes
  * %gD: reflog selector, e.g., refs/stash@{1}
  * %gd: shortened reflog selector, e.g., stash@{1}
  * %gs: reflog subject
  * %Cred: switch color to red
  * %Cgreen: switch color to green
  * %Cblue: switch color to blue
  * %Creset: reset color
  * %C(…): color specification, as described in color.branch.
  * %m: left, right or boundary mark
  * %n: newline
  * %%: a raw %
  * %x00: print a byte from a hex code
  * `%w([<w>[,<i1>[,<i2>]]])`: switch line wrapping, like the -w option of git-shortlog
ref: http://www.kernel.org/pub/software/scm/git/docs/git-log.html#_pretty_formats