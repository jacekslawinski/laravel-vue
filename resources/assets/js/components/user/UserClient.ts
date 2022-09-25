import AbstractClient from '@root/shared/AbstractClient';
import { User } from './User';

const USER_URL = 'api/user';

class UserClient extends AbstractClient {
  getUsers() {
    return this.get(USER_URL);
  }

  createUser(user: User) {
    return this.post(USER_URL, user.toRequest());
  }

  updateUser(user: User) {
    return this.put(`${USER_URL}/${user.id}`, user.toRequest());
  }

  deleteUser(user: User) {
    return this.delete(`${USER_URL}/${user.id}`);
  }
}

export default UserClient
