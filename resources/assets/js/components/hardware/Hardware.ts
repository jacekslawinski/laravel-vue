import { _ } from '@root/main';
import { User } from '../user/User';

interface UserHardwareInterface {
  user: User;
}

class UserHardware implements UserHardwareInterface {
  user: User;

  constructor(userHardware: Partial<UserHardwareInterface>) {
    this.user = new User(userHardware.user || {});
  }
}

export interface HardwareInterface {
  id: number|null;
  name: string|null;
  serialNumber: string|null;
  productionMonth: string|null;
  systemId: number|null;
  userHardware: UserHardwareInterface|null;
}

export class Hardware implements HardwareInterface {
  id: number|null;
  name: string|null;
  serialNumber: string|null;
  productionMonth: string|null;
  systemId: number|null;
  userHardware: UserHardwareInterface|null;

  constructor(hardware: Partial<HardwareInterface>) {
    this.id = _.get(hardware, 'id', null);
    this.name = _.get(hardware, 'name', null);
    this.serialNumber = _.get(hardware, 'serialNumber', null);
    this.productionMonth = _.get(hardware, 'productionMonth', null);
    this.systemId = _.get(hardware, 'systemId', null);
    this.userHardware = hardware.userHardware ? new UserHardware(hardware.userHardware) : null;
  }

  toRequest() {
    return {
      name: this.name,
      serial_number: this.serialNumber,
      production_month: this.productionMonth,
      system_id: this.systemId
    };
  }
}
