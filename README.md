# Backend Assesment

## 1. Online Store

### Problem

Imo the problem occurs when multiple users try to checkout same product at once, one's data gets interrupted. To prevent this race condition, i attempt to lock one user's transaction. So when a user access tries to checkout a product order, other users actions to access the same product will wait until previous transaction finished. So i use method lockForUpdate() on checkout function.

I also uploaded postman colletion on root folder.

#### Step

##### Run docker

./vendor/bin/sail up

##### Migrate

./vendor/bin/sail artisan migrate

##### Register

##### Login

##### Create Product

##### Order Product

##### Checkout / Cancel Order

## 2. Treasure Hunt

File stored in treasureHunt.php
