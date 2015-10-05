# Custom Ticket Fields #

  * ref: http://trac.edgewall.org/wiki/TracTicketsCustomFields

# Custom Workflow #

  * ref: [TracWorkflow](http://trac.edgewall.org/wiki/TracWorkflow)

  * setting 1

![http://img269.imageshack.us/img269/2329/tracworkflowv120091126.png](http://img269.imageshack.us/img269/2329/tracworkflowv120091126.png)

```
[ticket-workflow]
accept = new,assigned,reopened -> in_work
accept.operations = set_owner_to_self
accept.permissions = TICKET_MODIFY
done = assigned,in_work,reopened -> in_review
done.operations = set_resolution
done.permissions = TICKET_MODIFY
fail = in_review -> assigned
fail.permissions = TICKET_ADMIN
leave = * -> *
leave.default = 1
leave.operations = leave_status
reassign = new,assigned,in_work,reopened -> assigned
reassign.operations = set_owner
reassign.permissions = TICKET_MODIFY
reopen = closed -> reopened
reopen.operations = del_resolution
reopen.permissions = TICKET_CREATE
resolve = in_review -> closed
resolve.permissions = TICKET_ADMIN
```

  * setting 2

![http://commondatastorage.googleapis.com/0000/muchiii/tracworkflow_v1.1.png](http://commondatastorage.googleapis.com/0000/muchiii/tracworkflow_v1.1.png)

```
[ticket-workflow]
fail = in_review -> assigned
fail.operations = del_resolution
fail.permissions = TICKET_MODIFY
fix = assigned -> in_review
fix.operations = set_resolution
fix.set_resolution = fixed
fix.permissions = TICKET_MODIFY
fix.default = 1
leave = * -> *
leave.default = 2
leave.operations = leave_status
reassign = new,assigned,reopened -> assigned
reassign.operations = set_owner
reassign.permissions = TICKET_MODIFY
reopen = closed -> reopened
reopen.operations = del_resolution
reopen.permissions = TICKET_CREATE
resolve = new,assigned -> closed
resolve.operations = set_resolution
resolve.permissions = TICKET_MODIFY
verify = in_review -> closed
verify.permissions = TICKET_MODIFY
```

  * setting 2

![http://commondatastorage.googleapis.com/0000/muchiii/tracworkflow_v1.3.png](http://commondatastorage.googleapis.com/0000/muchiii/tracworkflow_v1.3.png)

```
[ticket-workflow]
accept = new,assigned,reopened -> accepted
accept.permissions = TICKET_MODIFY
accept.operations = set_owner_to_self
fail = in_review -> assigned
fail.operations = del_resolution
fail.permissions = TICKET_MODIFY
fail.name = Verify as failed
leave = * -> *
leave.default = 2
leave.operations = leave_status
reassign = new,assigned,reopened,accepted -> assigned
reassign.operations = set_owner
reassign.permissions = TICKET_MODIFY
reopen = closed -> reopened
reopen.operations = del_resolution
reopen.permissions = TICKET_CREATE
resolve = assigned,accepted -> in_review
resolve.operations = set_resolution
resolve.permissions = TICKET_MODIFY
verify = in_review -> closed
verify.name = Verify as succeed
verify.permissions = TICKET_MODIFY
```