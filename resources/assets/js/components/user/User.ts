import { _ } from '@root/main';
import { Hardware } from '@component/hardware/Hardware';

interface UserHardwareInterface {
  hardware: Hardware;
}

class UserHardware implements UserHardwareInterface {
  hardware: Hardware;

  constructor(userHardware: Partial<UserHardwareInterface>) {
    this.hardware = new Hardware(userHardware.hardware || {});
  }
}

export interface UserInterface {
  id: number|null;
  firstname: string|null;
  lastname: string|null;
  email: string|null;
  userHardwares: UserHardwareInterface[];
}

export class User implements UserInterface {
  id: number|null;
  firstname: string|null;
  lastname: string|null;
  email: string|null;
  userHardwares: UserHardwareInterface[];

  constructor(user: Partial<UserInterface>) {
    this.id = _.get(user, 'id', null);
    this.firstname = _.get(user, 'firstname', null);
    this.lastname = _.get(user, 'lastname', null);
    this.email = _.get(user, 'email', null);
    this.userHardwares = [];
    if (user.userHardwares) {
      user.userHardwares!.forEach((userHardware: UserHardwareInterface) => {
        this.userHardwares.push(new UserHardware(userHardware));
      });
    }
  }

  toRequest() {
    return {
      firstname: this.firstname,
      lastname: this.lastname,
      email: this.email
    };
  }

  getFullname() {
    return `${this.firstname} ${this.lastname}`;
  }
}
