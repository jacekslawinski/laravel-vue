import { _ } from '@root/main';

export interface SystemInterface {
  id: number|null;
  name: string|null;
}

export class System implements SystemInterface {
  id: number|null;
  name: string|null;

  constructor(system: Partial<SystemInterface>) {
    this.id = _.get(system, 'id', null);
    this.name = _.get(system, 'name', null);
  }

  toRequest() {
    return {
      name: this.name
    };
  }
}
